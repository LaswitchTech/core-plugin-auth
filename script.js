const LOGOUT_TIMEOUT = 15 * 60 * 1000; // 15 minutes
let logoutTimer;

const INACTIVITY_TIMEOUT = 1 * 60 * 1000; // 1 minutes
let inactivityTimer;

// Reset the inactivity timer
function resetInactivityTimer() {

    // Set the user as active
    $.ajax({
        url: '/api/auth/setActive',
        type: 'GET',dataType: 'json',
        success: function(response) {
            $('body').removeClass('animate-shake-once');
        }
    });

    // Timer to Set the user as inactive
    clearTimeout(inactivityTimer);
    inactivityTimer = setTimeout(() => {
        $.ajax({
            url: '/api/auth/setInactive',
            type: 'GET',dataType: 'json',
            success: function(response) {
                $('body').addClass('animate-shake-once');
            }
        });
    }, INACTIVITY_TIMEOUT);

    // Timer to Log out the user after the timeout
    clearTimeout(logoutTimer);
    logoutTimer = setTimeout(() => {
        // window.location.href = '?signout';
    }, LOGOUT_TIMEOUT);
}

// Set up the inactivity timer on page load
window.addEventListener('load', () => {

    // Check if the user is logged in
    if(USER_ID){

        // Start the logout timer
        resetInactivityTimer();

        // Add various event listeners to reset the inactivity timer
        // document.addEventListener('mousemove', resetInactivityTimer);
        document.addEventListener('keydown', resetInactivityTimer);
        document.addEventListener('click', resetInactivityTimer);
        document.addEventListener('scroll', resetInactivityTimer);
        document.addEventListener('touchstart', resetInactivityTimer);
        // document.addEventListener('touchmove', resetInactivityTimer);
        document.addEventListener('touchend', resetInactivityTimer);
        window.addEventListener('beforeunload', resetInactivityTimer);
        window.addEventListener('resize', resetInactivityTimer);
    }
});
