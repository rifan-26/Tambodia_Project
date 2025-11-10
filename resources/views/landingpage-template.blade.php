<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPS Sumatera Utara - Digital Signage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background: #f5f5f5;
            height: 100vh;
            overflow: hidden;
        }

        .template-container {
            width: 100vw;
            height: 100vh;
            display: grid;
            gap: {{ $template->grid_config['gap'] ?? '20px' }};
            padding: {{ $template->grid_config['padding'] ?? '30px' }};
            grid-template-columns: repeat({{ $template->grid_config['columns'] ?? 2 }}, 1fr);
            grid-template-rows: repeat({{ $template->grid_config['rows'] ?? 2 }}, 1fr);
        }

        .template-area {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .element-text {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 0;
            left: 0;
        }

        .element-color {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .element-image {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .element-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .template-container {
                grid-template-columns: 1fr;
                grid-template-rows: auto;
                padding: 15px;
                gap: 15px;
            }

            .template-area {
                min-height: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="template-container">
        @if($template && $template->grid_config && $template->grid_config['areas'])
            @foreach($template->grid_config['areas'] as $area)
                <div class="template-area" 
                     style="grid-column: {{ $area['col'] }} / span {{ $area['colSpan'] }}; 
                            grid-row: {{ $area['row'] }} / span {{ $area['rowSpan'] }};">
                    
                    @php
                        $areaElements = collect($template->elements)->where('gridArea', $area['id']);
                    @endphp

                    @foreach($areaElements as $element)
                        @if($element['type'] === 'color')
                            <div class="element-color" 
                                 style="background-color: {{ $element['styles']['backgroundColor'] ?? '#ffffff' }}; 
                                        opacity: {{ $element['styles']['opacity'] ?? 1 }};">
                            </div>
                        @elseif($element['type'] === 'image')
                            <div class="element-image">
                                <img src="{{ $element['imagePath'] ?? '' }}" 
                                     alt="Template Image"
                                     style="object-fit: {{ $element['styles']['objectFit'] ?? 'cover' }}; 
                                            object-position: {{ $element['styles']['objectPosition'] ?? 'center' }}; 
                                            opacity: {{ $element['styles']['opacity'] ?? 1 }};">
                            </div>
                        @elseif($element['type'] === 'text')
                            <div class="element-text" 
                                 style="font-size: {{ $element['styles']['fontSize'] ?? '18px' }}; 
                                        color: {{ $element['styles']['color'] ?? '#333333' }}; 
                                        font-weight: {{ $element['styles']['fontWeight'] ?? 'normal' }}; 
                                        text-align: {{ $element['styles']['textAlign'] ?? 'center' }}; 
                                        padding: {{ $element['styles']['padding'] ?? '20px' }};">
                                {{ $element['content'] ?? '' }}
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
