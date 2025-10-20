<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page BPS Sumatera Utara</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Arial', sans-serif;
            overflow: hidden;
        }

        .container {
            height: 100vh;
            width: 100vw;
            position: relative;
            background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 50%, rgba(0, 0, 0, 0.2) 100%);
        }

        .content-wrapper {
            position: relative;
            height: 100%;
            display: flex;
            z-index: 2;
            padding: 40px;
            align-items: center;
        }

        .main-content {
            flex: 1;
            max-width: 600px;
            padding-right: 40px;
        }

        .welcome-text {
            font-size: 48px;
            font-weight: normal;
            color: white;
            line-height: 1.2;
            margin-bottom: 8px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .agency-name {
            font-size: 52px;
            font-weight: bold;
            color: white;
            line-height: 1.1;
            margin-bottom: 40px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .bps-highlight {
            color: #0066cc;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }

        .description {
            font-size: 18px;
            color: white;
            line-height: 1.6;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
            font-weight: normal;
        }

        .photo-grid-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            max-height: 100vh;
            overflow: hidden;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            grid-auto-rows: minmax(120px, auto);
            gap: 12px;
            width: 100%;
            max-width: 500px;
            height: auto;
            max-height: 80vh;
            overflow: hidden;
        }

        .photo-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            background: #333;
        }

        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Dynamic grid sizing based on content */
        .photo-item:nth-child(1) {
            grid-column: span 2;
            grid-row: span 2;
        }

        .photo-item:nth-child(5n+2) {
            grid-row: span 2;
        }

        .photo-item:nth-child(7n+3) {
            grid-column: span 2;
        }

        .photo-item:nth-child(11n+4) {
            grid-column: span 2;
            grid-row: span 2;
        }

        /* Responsive untuk Portrait/Signage */
        @media (max-aspect-ratio: 3/4) {
            .content-wrapper {
                flex-direction: column;
                padding: 20px 15px;
                justify-content: flex-start;
                gap: 20px;
            }

            .main-content {
                flex: none;
                text-align: center;
                max-width: none;
                padding-right: 0;
            }

            .welcome-text {
                font-size: 32px;
                margin-bottom: 5px;
            }

            .agency-name {
                font-size: 36px;
                margin-bottom: 15px;
            }

            .description {
                font-size: 14px;
                margin-bottom: 0;
            }

            .photo-grid-container {
                flex: 1;
                padding: 0;
                display: flex;
                align-items: flex-start;
                justify-content: center;
                min-height: 0;
            }

            .photo-grid {
                width: 100%;
                max-width: 95%;
                height: auto;
                max-height: none;
                grid-template-columns: repeat(3, 1fr);
                grid-auto-rows: minmax(80px, auto);
                gap: 8px;
                overflow: visible;
            }

            /* Reset grid patterns untuk portrait */
            .photo-item:nth-child(1) {
                grid-column: span 2;
                grid-row: span 2;
            }

            .photo-item:nth-child(5n+2) {
                grid-row: span 1;
            }

            .photo-item:nth-child(7n+3) {
                grid-column: span 1;
            }

            .photo-item:nth-child(11n+4) {
                grid-column: span 1;
                grid-row: span 1;
            }

            .photo-item:nth-child(4) {
                grid-column: span 2;
            }

            .photo-item:nth-child(6) {
                grid-row: span 2;
            }
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding: 20px 15px;
            }

            .welcome-text {
                font-size: 28px;
            }

            .agency-name {
                font-size: 32px;
            }

            .description {
                font-size: 14px;
            }

            .photo-grid {
                grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
                grid-auto-rows: minmax(80px, auto);
                gap: 8px;
            }
        }

        @media (min-width: 1400px) {
            .photo-grid {
                max-width: 600px;
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
                grid-auto-rows: minmax(140px, auto);
                gap: 15px;
            }
        }

        /* Additional grid patterns for more photos */
        .photo-grid:has(.photo-item:nth-child(9)) .photo-item:nth-child(6) {
            grid-column: span 2;
        }

        .photo-grid:has(.photo-item:nth-child(12)) .photo-item:nth-child(8) {
            grid-row: span 2;
        }

        .photo-grid:has(.photo-item:nth-child(15)) .photo-item:nth-child(10) {
            grid-column: span 2;
            grid-row: span 2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="overlay"></div>
        
        <div class="content-wrapper">
            <div class="main-content">
                <div class="welcome-text">Selamat Datang Di</div>
                <div class="agency-name">
                    <span class="bps-highlight">BPS</span> Provinsi<br>Sumatera Utara
                </div>
                <p class="description">
                    Kami adalah lembaga resmi pemerintah yang bertugas menyelenggarakan kegiatan statistik di wilayah Sumatera Utara. BPS hadir untuk memberikan data akurat, terpercaya, dan terkini.
                </p>
            </div>
            
            <div class="photo-grid-container">
                <div class="photo-grid">
                    <!-- Sample photos - akan diisi dari admin panel -->
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1551029506-0807df4e2031?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Sample Photo 1">
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Sample Photo 2">
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Sample Photo 3">
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Sample Photo 4">
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Sample Photo 5">
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Sample Photo 6">
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1486312338219-ce68e2c6b7d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Sample Photo 7">
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Sample Photo 8">
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1573164713988-8665fc963095?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Sample Photo 9">
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Sample Photo 10">
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Sample Photo 11">
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Sample Photo 12">
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1515879218367-8466d910aaa4?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Sample Photo 13">
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Sample Photo 14">
                    </div>
                    <div class="photo-item">
                        <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Sample Photo 15">
                    </div>
                </div>
            </div>
        </div>
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</body>
</html>
