let numbers = [document.querySelectorAll(".calc-element")][0];
nums = {};
for (number of numbers) {
  nums[number.value] = number;
}

let calc = document.querySelector('.equation');
function addText(text) {
  text = text.srcElement.value;
  calc.value += text + " ";
}

for (num in nums) {
  nums[num].addEventListener('click', addText);
}

let del = document.querySelector(".delete");
del.addEventListener('click', C);

function C() {
  calc.value = '';
}

calc.value = res;