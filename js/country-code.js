document.addEventListener("DOMContentLoaded", function () {
const countrycode=document.querySelector('#countryCode');

fetch("https://gist.githubusercontent.com/anubhavshrimal/75f6183458db8c453306f93521e93d37/raw/f77e7598a8503f1f70528ae1cbf9f66755698a16/CountryCodes.json")
.then((res)=>{return res.json()})
.then((data)=>{
    countrycode.innerHTML= `<option value="">Country Code</option>`;
    data.forEach(code => {
            countrycode.innerHTML+=`<option value="${code.dial_code.replace('+', '')}" ${code.name==='India'?"selected":""}>${code.dial_code}(${code.code}) ${code.name}</option>`
            
            
            
            // countrycode.innerHTML+=`<option value="${code.dial_code} ${code.name}">${code.dial_code}(${code.code}) ${code.name}</option>`

    });
})
});
