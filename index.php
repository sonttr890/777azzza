<?php
// This PHP file serves the HTML content with embedded CSS and JS
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TikTok User Info</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(180deg, #1a1a1a 0%, #2c2c2c 100%);
            color: #e0e0e0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
        }

        .container {
            background: rgba(30, 30, 30, 0.95);
            padding: 2rem;
            border-radius: 12px;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        h1 {
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #ffffff;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-size: 0.9rem;
            color: #b0b0b0;
            margin-bottom: 0.5rem;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            background: #2a2a2a;
            border: 1px solid #404040;
            border-radius: 8px;
            color: #e0e0e0;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #4a90e2;
        }

        button {
            width: 100%;
            padding: 0.9rem;
            background: #4a90e2;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: background 0.3s ease;
        }

        button:disabled {
            background: #357abd;
            cursor: not-allowed;
        }

        button:hover:not(:disabled) {
            background: #357abd;
        }

        .loading {
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 4px;
            background: #ffffff;
            opacity: 0.8;
            animation: loadingBar 1.5s ease-in-out infinite;
        }

        @keyframes loadingBar {
            0% { width: 0; }
            50% { width: 100%; }
            100% { width: 0; }
        }

        .result {
            margin-top: 2rem;
            padding: 1.5rem;
            background: #252525;
            border-radius: 10px;
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .result.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: block;
            border: 2px solid #4a90e2;
            transition: transform 0.3s ease;
        }

        .profile-img:hover {
            transform: scale(1.05);
        }

        .username {
            font-size: 1.4rem;
            font-weight: 600;
            color: #ffffff;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .bio {
            font-size: 0.9rem;
            color: #b0b0b0;
            text-align: center;
            margin-bottom: 1rem;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
            text-align: center;
        }

        .stat {
            background: #2a2a2a;
            padding: 0.75rem;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .stat:hover {
            transform: translateY(-3px);
        }

        .stat h3 {
            font-size: 0.8rem;
            color: #b0b0b0;
            margin-bottom: 0.3rem;
        }

        .stat p {
            font-size: 1rem;
            color: #ffffff;
            font-weight: 500;
        }

        .videos {
            font-size: 0.9rem;
            color: #b0b0b0;
            text-align: center;
            margin: 1rem 0;
        }

        .profile-link {
            display: block;
            text-align: center;
            color: #4a90e2;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .profile-link:hover {
            color: #357abd;
        }

        .error {
            color: #ff6b6b;
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .error.show {
            display: block;
            opacity: 1;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.3;
        }

        @media (max-width: 480px) {
            .container {
                padding: 1.5rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            .profile-img {
                width: 60px;
                height: 60px;
            }

            .username {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <div class="container">
        <h1>TikTok User Info</h1>
        <form id="tiktokForm">
            <div class="input-group">
                <label for="username">TikTok Username (without @)</label>
                <input type="text" id="username" name="username" placeholder="e.g. tiktok" required>
            </div>
            <button type="submit" id="submitBtn">Get Info</button>
        </form>
        <div class="result" id="result">
            <img id="profileImg" class="profile-img" src="" alt="Profile Picture">
            <h2 id="usernameDisplay" class="username"></h2>
            <p id="bio" class="bio"></p>
            <div class="stats">
                <div class="stat">
                    <h3>Followers</h3>
                    <p id="followers"></p>
                </div>
                <div class="stat">
                    <h3>Following</h3>
                    <p id="following"></p>
                </div>
                <div class="stat">
                    <h3>Likes</h3>
                    <p id="likes"></p>
                </div>
            </div>
            <p class="videos"><strong>Videos:</strong> <span id="videos"></span></p>
            <a id="profileLink" class="profile-link" href="#" target="_blank">Visit Profile</a>
        </div>
        <p class="error" id="error"></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        // Particle.js for subtle background effect
        particlesJS('particles-js', {
            particles: {
                number: { value: 50, density: { enable: true, value_area: 1000 } },
                color: { value: '#4a90e2' },
                shape: { type: 'circle' },
                opacity: { value: 0.3, random: true },
                size: { value: 2, random: true },
                line_linked: { enable: false },
                move: {
                    enable: true,
                    speed: 1,
                    direction: 'none',
                    random: true,
                    straight: false,
                    out_mode: 'out'
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: { enable: false },
                    onclick: { enable: false },
                    resize: true
                }
            },
            retina_detect: true
        });

        // Form submission handling
        const form = document.getElementById('tiktokForm');
        const submitBtn = document.getElementById('submitBtn');
        const resultDiv = document.getElementById('result');
        const errorDiv = document.getElementById('error');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Reset previous states
            resultDiv.classList.remove('show');
            errorDiv.classList.remove('show');
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');
            submitBtn.textContent = 'Fetching...';

            const username = document.getElementById('username').value.trim();

            try {
                const response = await fetch(`https://tiktok-info-user.vercel.app/tiktok-info?key=777azza&usertarget=${encodeURIComponent(username)}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    },
                    mode: 'cors',
                    credentials: 'omit'
                });

                if (!response.ok) {
                    throw new Error(`Network error: ${response.status} ${response.statusText}`);
                }

                const data = await response.json();

                if (!data || !Array.isArray(data) || data.length === 0 || !data[0]) {
                    throw new Error('User not found or invalid data returned');
                }

                const user = data[0];

                // Validate required fields
                if (!user.username || !user.url || !user.image) {
                    throw new Error('Incomplete user data');
                }

                // Update UI with user data
                document.getElementById('profileImg').src = user.image;
                document.getElementById('usernameDisplay').textContent = `@${user.username}`;
                document.getElementById('bio').textContent = user.bio || 'No bio available';
                document.getElementById('followers').textContent = formatNumber(user.followers?.formatted || 0);
                document.getElementById('following').textContent = formatNumber(user.following?.formatted || 0);
                document.getElementById('likes').textContent = formatNumber(user.likes?.formatted || 0);
                document.getElementById('videos').textContent = formatNumber(user.videos?.formatted || 0);
                document.getElementById('profileLink').href = user.url;

                resultDiv.classList.add('show');
            } catch (error) {
                console.error('Fetch Error:', error);
                let errorMessage = error.message || 'An unexpected error occurred';
                if (error.message.includes('Failed to fetch')) {
                    errorMessage = 'Unable to fetch data. This might be due to CORS restrictions. Try running this on a server with proper CORS handling or use a proxy.';
                }
                errorDiv.textContent = errorMessage;
                errorDiv.classList.add('show');
            } finally {
                submitBtn.disabled = false;
                submitBtn.classList.remove('loading');
                submitBtn.textContent = 'Get Info';
            }
        });

        // Number formatting function
        function formatNumber(num) {
            if (typeof num !== 'number') return 'N/A';
            if (num >= 1000000) return (num / 1000000).toFixed(1) + 'M';
            if (num >= 1000) return (num / 1000).toFixed(1) + 'K';
            return num.toString();
        }
    </script>
</body>
</html>
