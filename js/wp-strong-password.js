/**
 * File to handle strong password request on user profile page.
 *
 * @package wp-strong-pass
 */

var passwordField = document.getElementById( 'pass1' );
var saveForm      = document.getElementById( 'submit' );

/**
 * Event to check password strength before save.
 */
saveForm.addEventListener(
	'click',
	function ( event ) {

		if ( true === passwordField.disabled ) {
			return;
		}

		// If password is not strong then return error.
		if ( 4 > wp.passwordStrength.meter( passwordField.value, '' ) ) {
			event.preventDefault();
			alert( 'Weak password strictly prohibited.' );
		}

		return;
	}
);
