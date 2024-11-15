function togglePassword(fieldName) {
	// Select the password field based on its 'name' attribute
	const passwordField = document.querySelector(`input[name="${fieldName}"]`);

	// Select the corresponding icon by targeting the element with 'toggle-password' class and matching 'onclick' attribute
	const icon = document.querySelector(
		`.toggle-password[onclick*="${fieldName}"]`,
	);

	// Check if the password field is currently of type 'password'
	if (passwordField.type === "password") {
		// Change the field type to 'text' to show the password
		passwordField.type = "text";

		// Update the icon to 'eye-slash' to indicate that the password is visible
		icon.classList.remove("fa-eye");
		icon.classList.add("fa-eye-slash");
	} else {
		// Revert the field type to 'password' to hide the password
		passwordField.type = "password";

		// Change the icon back to 'eye' to indicate that the password is hidden
		icon.classList.remove("fa-eye-slash");
		icon.classList.add("fa-eye");
	}
}
