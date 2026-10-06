function visiblePass() {
  const btnVisiblePass = document.getElementById("passLogin");
  const eyeOpen = document.querySelector(".eye_open");
  const eyeClose = document.querySelector(".eye_close");

  if (btnVisiblePass.type === "password") {
    btnVisiblePass.type = "text";
    eyeOpen.style.display = "block";
    eyeClose.style.display = "none";
  } else {
    btnVisiblePass.type = "password";
    eyeOpen.style.display = "none";
    eyeClose.style.display = "block";
  }
}