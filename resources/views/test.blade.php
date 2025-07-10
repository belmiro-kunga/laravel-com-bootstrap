<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
</head>
<body>
    @php
        $sliderImages = [
            'image1.jpg',
            'image2.jpg',
            'image3.jpg',
        ];
    @endphp
    
    @foreach($sliderImages as $idx => $img)
        <div>Image {{ $idx + 1 }}: {{ $img }}</div>
    @endforeach
    
    @foreach($sliderImages as $idx => $img)
        <button>Button {{ $idx + 1 }}</button>
    @endforeach
</body>
</html> 