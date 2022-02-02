const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-text");

form.onsubmit = (e)=>{ 
    e.preventDefault(); //preventing from submitting
}

continueBtn.onclick = ()=>{
    //Ajax starts here
    let xhr = new XMLHttpRequest(); //create XML object
    xhr.open("POST", "php/login.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              if(data === "success"){
                location.href = "users.php";
              }else{
                errorText.style.display = "block";
                errorText.textContent = data;
              }
          }
      }
    }
    //send the form data through ajax to php
    let formData = new FormData(form); //create new formData object
    xhr.send(formData); //send the form data to php
}