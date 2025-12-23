const exprInput = document.getElementById("expr");
const resultInput = document.getElementById("result");
const keys = document.getElementById("keys");

let expression = "";

function updateExpression() {
  exprInput.value = expression;
}

function clearAll() {
  expression = "";
  resultInput.value = "";
  updateExpression();
}

function backspace() {
  expression = expression.slice(0, -1);
  updateExpression();
}

function addSymbol(symbol) {
  expression += symbol;
  updateExpression();
}

function calculate() {
  if (!expression.trim()) {
    resultInput.value = "";
    return;
  }
  try {
    const safe = expression.replace(/[^0-9+\-*/().]/g, "");
    const result = Function('"use strict"; return (' + safe + ')')();
    resultInput.value = Number.isFinite(result) ? result : "Помилка";
  } catch {
    resultInput.value = "Помилка";
  }
}

keys.addEventListener("click", (event) => {
  const button = event.target.closest("button");
  if (!button) return;

  if (button.dataset.action === "clear") clearAll();
  else if (button.dataset.action === "back") backspace();
  else if (button.dataset.action === "equals") calculate();
  else if (button.dataset.value) addSymbol(button.dataset.value);
});

document.addEventListener("keydown", (e) => {
  const k = e.key;

  if (k === "Enter") {
    e.preventDefault();
    calculate();
    return;
  }

  if (k === "Backspace") {
    e.preventDefault();
    backspace();
    return;
  }

  if (k === "Escape") {
    e.preventDefault();
    clearAll();
    return;
  }

  if (k >= "0" && k <= "9") {
    addSymbol(k);
    return;
  }

  const allowed = ["+", "-", "*", "/", ".", "(", ")"];
  if (allowed.includes(k)) {
    addSymbol(k);
  }
});

updateExpression();
