<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktikum Web Framework: Kalkulator Sederhana</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('calculator/style.css') ?>">
</head>
<body>

    <!-- Animated background orbs -->
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="bg-orb bg-orb-3"></div>

    <div class="calculator-wrapper">
        <div class="calculator-header">
            <span class="header-dot red"></span>
            <span class="header-dot yellow"></span>
            <span class="header-dot green"></span>
            <span class="header-title">Kalkulator</span>
        </div>

        <div class="calculator">
            <!-- Display area -->
            <div class="display-container">
                <div id="expression" class="expression"></div>
                <input type="text" id="display" disabled placeholder="0">
            </div>

            <!-- Buttons grid -->
            <div class="buttons">
                <button class="btn-function" onclick="clearDisplay()">AC</button>
                <button class="btn-function" onclick="deleteLast()">
                    <svg width="22" height="18" viewBox="0 0 24 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 4H8l-7 8 7 8h13a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"></path>
                        <line x1="18" y1="9" x2="12" y2="15"></line>
                        <line x1="12" y1="9" x2="18" y2="15"></line>
                    </svg>
                </button>
                <button class="btn-function" onclick="appendValue('%')">%</button>
                <button class="btn-operator" onclick="appendValue('/')">÷</button>

                <button class="btn-number" onclick="appendValue('7')">7</button>
                <button class="btn-number" onclick="appendValue('8')">8</button>
                <button class="btn-number" onclick="appendValue('9')">9</button>
                <button class="btn-operator" onclick="appendValue('*')">×</button>

                <button class="btn-number" onclick="appendValue('4')">4</button>
                <button class="btn-number" onclick="appendValue('5')">5</button>
                <button class="btn-number" onclick="appendValue('6')">6</button>
                <button class="btn-operator" onclick="appendValue('-')">−</button>

                <button class="btn-number" onclick="appendValue('1')">1</button>
                <button class="btn-number" onclick="appendValue('2')">2</button>
                <button class="btn-number" onclick="appendValue('3')">3</button>
                <button class="btn-operator" onclick="appendValue('+')">+</button>

                <button class="btn-number btn-zero" onclick="appendValue('0')">0</button>
                <button class="btn-number" onclick="appendValue('.')">.</button>
                <button class="btn-equals" onclick="calculate()">=</button>
            </div>
        </div>

        <p class="footer-text">Praktikum Pemrograman Aplikasi Web Framework</p>
    </div>

    <script src="<?= base_url('calculator/script.js') ?>"></script>
</body>
</html>
