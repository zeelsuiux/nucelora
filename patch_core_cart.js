const fs = require('fs');
let js = fs.readFileSync('public/assets/js/lymko-core.js', 'utf8');

const target = 'add.hasAttribute("data-openbag")||inDrawer?inDrawer||openO("cart"):(add.classList.add("ok"),add.innerHTML=T("added_btn","Added \\u2713"),setTimeout(()=>{add.classList.remove("ok"),add.innerHTML=orig},1500))';
const replacement = 'openO("cart"),window.dispatchEvent(new CustomEvent("cart:refresh"))';

if (js.includes(target)) {
  js = js.replace(target, replacement);
  fs.writeFileSync('public/assets/js/lymko-core.js', js, 'utf8');
  console.log('Replaced successfully');
} else {
  console.log('Target not found');
}
