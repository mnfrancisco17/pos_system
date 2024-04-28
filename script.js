// Client-side validation for the login form
function validateLoginForm() {
  var username = document.getElementById("username").value;
  var password = document.getElementById("password").value;
  var errorMessage = document.getElementById("error-message");

  // Check if username and password fields are empty
  if (username.trim() === "" || password.trim() === "") {
    errorMessage.innerHTML = "Please enter both username and password.";
    return false;
  }

  return true;
}

// Client-side validation for the registration form
function validateRegistrationForm() {
  var username = document.getElementById("username").value;
  var password = document.getElementById("password").value;
  var confirmPassword = document.getElementById("confirm-password").value;
  var errorMessage = document.getElementById("error-message");

  // Check if any field is empty
  if (
    username.trim() === "" ||
    password.trim() === "" ||
    confirmPassword.trim() === ""
  ) {
    errorMessage.innerHTML = "Please fill in all fields.";
    return false;
  }

  // Check if passwords match
  if (password !== confirmPassword) {
    errorMessage.innerHTML = "Passwords do not match.";
    return false;
  }

  return true;
}

// Client-side validation for the product form
function validateProductForm() {
  var product = document.getElementById("product").value;
  var quantity = document.getElementById("quantity").value;
  var errorMessage = document.getElementById("error-message");

  // Check if product name or quantity is empty
  if (product.trim() === "" || quantity.trim() === "") {
    errorMessage.innerHTML = "Please fill in all fields.";
    return false;
  }

  // Check if quantity is a positive integer
  if (isNaN(quantity) || quantity <= 0 || Math.floor(quantity) !== +quantity) {
    errorMessage.innerHTML = "Please enter a valid quantity.";
    return false;
  }

  return true;
}
