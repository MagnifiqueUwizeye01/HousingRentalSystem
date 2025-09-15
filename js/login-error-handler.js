// js/register-error-handler.js

document.addEventListener("DOMContentLoaded", function () {
  const params = new URLSearchParams(window.location.search);
  const error = params.get("error");
  const success = params.get("success");

  const errorMsg = document.getElementById("error-msg");
  const successMsg = document.getElementById("success-msg");
  const messageContainer = document.getElementById("message-container");

  if (error && errorMsg) {
    errorMsg.textContent = decodeURIComponent(error.replace(/\+/g, ' '));
    messageContainer.style.display = "block";
  }

  if (success && successMsg) {
    successMsg.textContent = decodeURIComponent(success.replace(/\+/g, ' '));
    messageContainer.style.display = "block";
  }
});
