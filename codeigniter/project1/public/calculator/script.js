// ============================================
//  KALKULATOR PREMIUM — Script
// ============================================

const display    = document.getElementById('display');
const expression = document.getElementById('expression');

// --- Keep track of state ---
let currentInput   = '';
let lastExpression = '';
let justCalculated = false;

// --- Append value (number / operator / dot) ---
function appendValue(value) {
    // If we just calculated and user presses a number, start fresh
    if (justCalculated && !isOperator(value)) {
        currentInput = '';
        expression.textContent = '';
        justCalculated = false;
    }

    // If we just calculated and user presses operator, continue from result
    if (justCalculated && isOperator(value)) {
        justCalculated = false;
    }

    // Prevent multiple operators in a row
    if (isOperator(value) && isOperator(currentInput.slice(-1))) {
        currentInput = currentInput.slice(0, -1) + value;
    }
    // Prevent starting with an operator (except minus for negative)
    else if (isOperator(value) && currentInput === '' && value !== '-') {
        return;
    }
    else {
        currentInput += value;
    }

    display.value = formatDisplay(currentInput);
    adjustFontSize();
}

// --- Clear everything ---
function clearDisplay() {
    currentInput   = '';
    lastExpression = '';
    justCalculated = false;
    display.value  = '';
    expression.textContent = '';
    adjustFontSize();
}

// --- Delete last character ---
function deleteLast() {
    if (justCalculated) {
        clearDisplay();
        return;
    }
    currentInput  = currentInput.slice(0, -1);
    display.value = formatDisplay(currentInput);
    adjustFontSize();
}

// --- Calculate result ---
function calculate() {
    if (currentInput.trim() === '') return;

    try {
        // Show the expression at the top
        expression.textContent = formatDisplay(currentInput) + ' =';

        // Replace display symbols back to JS operators for eval
        let evalStr = currentInput;
        let result  = eval(evalStr);

        if (result === Infinity || result === -Infinity || isNaN(result)) {
            display.value = 'Error';
            currentInput  = '';
        } else {
            // Round to avoid floating point issues
            result = parseFloat(result.toPrecision(12));
            display.value = formatNumber(result);
            currentInput  = String(result);
        }

        justCalculated = true;
    } catch (error) {
        display.value  = 'Error';
        currentInput   = '';
        justCalculated = true;
    }

    adjustFontSize();
}

// --- Helper: check if character is an operator ---
function isOperator(char) {
    return ['+', '-', '*', '/', '%'].includes(char);
}

// --- Helper: format display string (show pretty symbols) ---
function formatDisplay(str) {
    return str
        .replace(/\*/g, '×')
        .replace(/\//g, '÷')
        .replace(/-/g, '−');
}

// --- Helper: format number with thousand separators ---
function formatNumber(num) {
    if (Number.isInteger(num) && Math.abs(num) < 1e15) {
        return num.toLocaleString('id-ID');
    }
    return String(num);
}

// --- Adjust font size based on content length ---
function adjustFontSize() {
    const len = display.value.length;
    display.classList.remove('small-text', 'smaller-text');

    if (len > 14) {
        display.classList.add('smaller-text');
    } else if (len > 9) {
        display.classList.add('small-text');
    }
}

// --- Ripple position for buttons ---
document.querySelectorAll('.buttons button').forEach(btn => {
    btn.addEventListener('pointerdown', (e) => {
        const rect = btn.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width) * 100;
        const y = ((e.clientY - rect.top)  / rect.height) * 100;
        btn.style.setProperty('--ripple-x', x + '%');
        btn.style.setProperty('--ripple-y', y + '%');

        // Pulse animation class
        btn.classList.remove('btn-press');
        void btn.offsetWidth; // trigger reflow
        btn.classList.add('btn-press');
    });
});

// --- Keyboard support ---
document.addEventListener('keydown', (e) => {
    const key = e.key;

    if (key >= '0' && key <= '9')  appendValue(key);
    else if (key === '.')          appendValue('.');
    else if (key === '+')          appendValue('+');
    else if (key === '-')          appendValue('-');
    else if (key === '*')          appendValue('*');
    else if (key === '/')        { e.preventDefault(); appendValue('/'); }
    else if (key === '%')          appendValue('%');
    else if (key === 'Enter')    { e.preventDefault(); calculate(); }
    else if (key === '=')         calculate();
    else if (key === 'Backspace') deleteLast();
    else if (key === 'Escape' || key === 'Delete') clearDisplay();
});
