<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Signature Pad demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
            user-select: none;
            margin: 0;
            padding: 32px 16px;
            background: #f5f5f5;
        }

        .signature-pad {
            width: 100%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .signature-pad canvas {
            width: 100%;
            height: 200px;
            border: 1px solid #000;
            border-radius: 4px;
        }

        .signature-pad--footer {
            margin-top: 20px;
        }

        .signature-pad--actions {
            display: flex;
            justify-content: space-between;
        }

        .signature-pad--actions .button {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border-radius: 4px;
            font-size: 14px;
        }

        .signature-pad--actions .button.clear {
            background-color: #dc3545;
        }

        .signature-pad--actions .button.save {
            background-color: #28a745;
        }
    </style>
</head>

<body onselectstart="return false">
    <div id="signature-pad" class="signature-pad">
        <div id="canvas-wrapper" class="signature-pad--body">
            <canvas id="signature-canvas"></canvas>
        </div>
        <div class="signature-pad--footer">
            <div class="description">Sign above</div>
            <div class="signature-pad--actions">
                <div class="column">
                    <button type="button" class="button clear" data-action="clear">Clear</button>
                    <button type="button" class="button" data-action="undo" title="Ctrl-Z">Undo</button>
                    <button type="button" class="button" data-action="redo" title="Ctrl-Y">Redo</button>
                </div>
                <div class="column">
                    <button type="button" class="button save" data-action="save-png">Save as PNG</button>
                    <button type="button" class="button save" data-action="save-jpg">Save as JPG</button>
                    <button type="button" class="button save" data-action="save-svg">Save as SVG</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <script>
        const canvas = document.getElementById('signature-canvas');
        const signaturePad = new SignaturePad(canvas);

        let undoStack = [];
        let redoStack = [];

        // Resize canvas when window is resized
        function resizeCanvas() {
            const ratio = window.devicePixelRatio || 1;
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext('2d').scale(ratio, ratio);
            signaturePad.clear();
        }

        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        // Save the current state to the undo stack whenever the signature pad is updated
        signaturePad.onEnd = () => {
            if (!signaturePad.isEmpty()) {
                undoStack.push(signaturePad.toDataURL()); // Push current state to undo stack
                redoStack = []; // Clear redo stack on new drawing
            }
        };

        // Clear button handler
        document.querySelector('[data-action="clear"]').addEventListener('click', () => {
            signaturePad.clear();
            undoStack = []; // Reset undo stack
            redoStack = []; // Reset redo stack
        });

        // Save image buttons
        document.querySelector('[data-action="save-png"]').addEventListener('click', () => saveImage('image/png'));
        document.querySelector('[data-action="save-jpg"]').addEventListener('click', () => saveImage('image/jpeg'));
        document.querySelector('[data-action="save-svg"]').addEventListener('click', () => saveImage('image/svg+xml'));

        // Undo button handler
        document.querySelector('[data-action="undo"]').addEventListener('click', () => {
            if (undoStack.length > 0) {
                const lastState = undoStack.pop();
                redoStack.push(signaturePad.toDataURL()); // Save current state to redo stack
                const img = new Image();
                img.src = lastState;
                img.onload = () => signaturePad.fromDataURL(lastState); // Restore last state
            }
        });

        // Redo button handler
        document.querySelector('[data-action="redo"]').addEventListener('click', () => {
            if (redoStack.length > 0) {
                const lastState = redoStack.pop();
                undoStack.push(signaturePad.toDataURL()); // Save current state to undo stack
                const img = new Image();
                img.src = lastState;
                img.onload = () => signaturePad.fromDataURL(lastState); // Restore redo state
            }
        });

        // Save image function
        function saveImage(type, withBackground = false) {
            let dataUrl;
            if (type === 'image/svg+xml') {
                dataUrl = signaturePad.toSVG({ backgroundColor: withBackground ? '#fff' : 'transparent' });
            } else {
                dataUrl = signaturePad.toDataURL(type);
            }
            const link = document.createElement('a');
            link.href = dataUrl;
            link.download = `signature.${type.split('/')[1]}`;
            link.click();
        }
    </script>
</body>

</html>
