<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in</title>
    <style>
        :root { color-scheme: light; font-family: Tahoma, sans-serif; background: #f4f6f8; color: #17212b; }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 16px; }
        form { width: 100%; max-width: 360px; background: #fff; border: 1px solid #dce2e7; border-radius: 8px; padding: 28px; }
        h1 { margin: 0 0 20px; font-size: 20px; }
        .field { margin-bottom: 16px; }
        label { display: block; margin-bottom: 6px; font-size: 14px; color: #56636e; }
        input { width: 100%; font: inherit; padding: 10px 12px; border: 1px solid #dce2e7; border-radius: 5px; }
        .error { margin-bottom: 16px; padding: 10px 12px; background: #fdecec; border: 1px solid #d64545; border-radius: 5px; color: #d64545; font-size: 14px; }
        .slider { position: relative; height: 48px; margin-bottom: 18px; border: 1px solid #dce2e7; border-radius: 24px; background: #eef2f5; overflow: hidden; user-select: none; }
        .slider-fill { position: absolute; left: 0; top: 0; bottom: 0; width: 0; background: #087f72; opacity: .18; }
        .slider-text { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; padding: 0 56px; font-size: 14px; color: #56636e; text-align: center; pointer-events: none; }
        .slider-knob { position: absolute; top: 2px; left: 2px; width: 44px; height: 44px; border-radius: 50%; background: #fff; color: #087f72; display: grid; place-items: center; box-shadow: 0 1px 4px rgba(0, 0, 0, .18); pointer-events: none; }
        .slider input[type=range] { position: absolute; inset: 0; width: 100%; height: 100%; margin: 0; opacity: 0; cursor: grab; }
        .slider.done { border-color: #087f72; background: #e6f6f4; }
        .slider.done .slider-fill { opacity: .35; }
        .slider.done .slider-text { color: #087f72; font-weight: 600; }
        .slider.done .slider-knob { background: #087f72; color: #fff; }
        .slider:focus-within { outline: 3px solid rgba(8, 127, 114, .35); outline-offset: 2px; }
        .slider:hover .slider-knob { box-shadow: 0 2px 8px rgba(8, 127, 114, .35); }
        button { width: 100%; font: inherit; padding: 10px; border: 0; border-radius: 5px; background: #087f72; color: #fff; cursor: pointer; }
    </style>
</head>
<body>
<form method="POST" action="{{ route('login.submit') }}">
    @csrf
    <h1>Sign in</h1>

    @error('username')
        <div class="error">{{ $message }}</div>
    @enderror

    <div class="field">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" autocomplete="username" required value="{{ old('username') }}">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required>
    </div>

    <div class="slider" id="robot_box">
        <div class="slider-fill" id="robot_fill"></div>
        <span class="slider-text" id="robot_text">Slide to confirm you are not a robot</span>
        <span class="slider-knob" id="robot_knob" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
        <input id="robot_slide" type="range" min="0" max="100" step="1" value="{{ old('not_a_robot') ? 100 : 0 }}" aria-label="Slide to confirm you are not a robot">
        <input id="not_a_robot" name="not_a_robot" type="hidden" value="{{ old('not_a_robot') ? '1' : '' }}">
    </div>
    @error('not_a_robot')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit">Sign in</button>
</form>
<script>
    (function () {
        var slide = document.getElementById('robot_slide');
        var box = document.getElementById('robot_box');
        var knob = document.getElementById('robot_knob');
        var fill = document.getElementById('robot_fill');
        var value = document.getElementById('not_a_robot');
        var text = document.getElementById('robot_text');

        function render() {
            var pct = Number(slide.value);
            var done = pct >= 100;
            var trackWidth = box.clientWidth - 46;
            knob.style.transform = 'translateX(' + (trackWidth * pct / 100) + 'px)';
            fill.style.width = (pct + 4) + '%';
            value.value = done ? '1' : '';
            box.classList.toggle('done', done);
            text.textContent = done ? 'Verified' : 'Slide to confirm you are not a robot';
        }

        slide.addEventListener('input', render);
        slide.addEventListener('change', function () {
            if (Number(slide.value) < 100) { slide.value = 0; render(); }
        });
        window.addEventListener('resize', render);
        render();
    })();
</script>
</body>
</html>
