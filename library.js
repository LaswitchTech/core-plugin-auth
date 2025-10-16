class ActivityMonitor {

    #status = false;
    #timeout = {
        logout: 15 * 60 * 1000, // 15 minutes
        inactive: 1 * 60 * 1000, // 1 minute
    }
    #timer = {
        logout: null,
        inactive: null,
    }
    #events = ['keydown','click','touchstart'];
    // #events = ['mousemove','keydown','click','scroll','touchstart','touchmove','touchend','beforeunload','resize'];

    constructor(){

        // Set Self
        const self = this;

        // Set up the inactivity timer on page load
        window.addEventListener('load', () => {

            // Check if the user is logged in
            if(USER_ID){

                // Add various event listeners to reset the inactivity timer
                for(const event of self.#events){
                    document.addEventListener(event, () => { self.#start(); });
                }
            }
        });
    }

    #reset(){

        // Clear existing timers
        clearTimeout(this.#timer.inactive);
        clearTimeout(this.#timer.logout);
    }

    #start(){

        // Clear existing timers
        this.#reset();

        // Check if enabled
        if(!this.#status) return;

        // Check if the user is logged in
        if(!USER_ID) return;

        // Set the user as active
        API.endpoint('/auth/setActive').suppress().execute(function(response){
            $('body').removeClass('animate-shake-once');
        });

        // Timer to Set the user as inactive
        this.#timer.inactive = setTimeout(() => {
            API.endpoint('/auth/setInactive').suppress().execute(function(response){
                $('body').addClass('animate-shake-once');
            });
        }, this.#timeout.inactive);

        // Timer to Log out the user after the timeout
        this.#timer.logout = setTimeout(() => {
            if(DEV_MODE) return;
            // window.location.href = '?signout';
        }, this.#timeout.logout);
    }

    start(){
        this.#status = true;
        this.#start();
    }

    stop(){
        this.#status = false;
        this.#reset();
    }

    setTimeout(type = 'logout', milliseconds = 15 * 60 * 1000){
        if(type in this.#timeout){
            this.#timeout[type] = milliseconds;
            this.#start();
        }
    }
}

// Create Endpoint Instance
const Monitor = new ActivityMonitor();

// Start Monitoring if User is logged in
Monitor.start();
