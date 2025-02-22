from flask import Flask, request, jsonify
import subprocess
import os



app = Flask(__name__)

DOWNLOAD_FOLDER = "downloads"
os.makedirs(DOWNLOAD_FOLDER, exist_ok=True)

@app.route('/download', methods=['POST'])
def download_video():
    data = request.get_json()
    url = data.get("url")
    
    if not url:
        return jsonify({"error": "No URL provided"}), 400
    
    try:
        command = [
            "yt-dlp", "-f", "best", "-o",
            os.path.join(DOWNLOAD_FOLDER, "%(title)s.%(ext)s"),
            url
        ]
        subprocess.run(command, check=True)
        return jsonify({"message": "Download started successfully!"})
    except subprocess.CalledProcessError as e:
        return jsonify({"error": "Failed to download video", "details": str(e)})

if __name__ == '__main__':
    app.run(debug=True)
