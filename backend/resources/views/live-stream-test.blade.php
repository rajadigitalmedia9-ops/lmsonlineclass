<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Stream Test (MediaMTX)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-4 text-gray-800">MediaMTX Live Stream Prototype</h1>
        
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
            <h3 class="font-semibold text-blue-800">How to test:</h3>
            <ol class="list-decimal ml-5 text-blue-700 text-sm mt-2">
                <li>Make sure Docker Compose is running (`docker compose up -d`).</li>
                <li>Publish a stream named <strong>mystream</strong>.
                    <br><em>Via OBS:</em> Stream to `rtmp://localhost/mystream`
                    <br><em>Via WebRTC:</em> Open <a href="http://localhost:8889/mystream/publish" class="underline" target="_blank">http://localhost:8889/mystream/publish</a> and click Publish.
                </li>
                <li>Wait 1-2 seconds, and the player below should start playing the stream via HLS!</li>
            </ol>
        </div>

        <div class="relative pt-[56.25%] bg-black rounded overflow-hidden">
            <video-js
                id="live-player"
                class="vjs-default-skin absolute top-0 left-0 w-full h-full"
                controls
                preload="auto"
                data-setup='{"fluid": true}'>
                <source src="http://localhost:8888/mystream/index.m3u8" type="application/x-mpegURL">
                <p class="vjs-no-js">
                    To view this video please enable JavaScript, and consider upgrading to a
                    web browser that supports HTML5 video.
                </p>
            </video-js>
        </div>
        
        <div class="mt-4 flex gap-4">
            <a href="http://localhost:8889/mystream/" target="_blank" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 text-sm font-medium">
                Watch via WebRTC (Sub-second Latency)
            </a>
            <button onclick="document.getElementById('live-player').player.play()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">
                Reload HLS Player
            </button>
        </div>
    </div>

    <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
</body>
</html>
