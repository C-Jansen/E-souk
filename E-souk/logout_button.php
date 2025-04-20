<style>
        /* Ensure content doesn't get hidden behind fixed sidebar */
        .admin-content-wrapper {
            padding-left: 60px; /* Start with closed sidebar width */
            transition: padding-left 300ms ease-in-out; /* Match sidebar transition */
        }
        #admin-sidebar:not(.close) + .admin-content-wrapper {
            padding-left: 250px; /* Adjust padding when sidebar is open */
        }
        /* Basic styling for flash messages */
        .flash-messages {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1050; /* Above sidebar */
        }
        .flash-message {
            padding: 10px 20px;
            margin-bottom: 10px;
            border-radius: 5px;
            color: #fff;
            min-width: 200px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .flash-success { background-color: #28a745; }
        .flash-error { background-color: #dc3545; }
        .flash-warning { background-color: #ffc107; color: #333;}
        .flash-info { background-color: #17a2b8; }
    </style>

            {# Logout Button #}
            <li class="logout-item">
                <button class="logoutButton logoutButton--dark" type="button" title="Log Out">
                    <svg class="doorway" viewBox="0 0 100 100"><path d="M93.4 86.3H58.6c-1.9 0-3.4-1.5-3.4-3.4V17.1c0-1.9 1.5-3.4 3.4-3.4h34.8c1.9 0 3.4 1.5 3.4 3.4v65.8c0 1.9-1.5 3.4-3.4 3.4z"></path><path class="bang" d="M40.5 43.7L26.6 31.4l-2.5 6.7zM41.9 50.4l-19.5-4-1.4 6.3zM40 57.4l-17.7 3.9 3.9 5.7z"></path></svg>
                    <svg class="figure" viewBox="0 0 100 100"><circle cx="52.1" cy="32.4" r="6.4"></circle><path d="M50.7 62.8c-1.2 2.5-3.6 5-7.2 4-3.2-.9-4.9-3.5-4-7.8.7-3.4 3.1-13.8 4.1-15.8 1.7-3.4 1.6-4.6 7-3.7 4.3.7 4.6 2.5 4.3 5.4-.4 3.7-2.8 15.1-4.2 17.9z"></path><g class="arm1"><path d="M55.5 56.5l-6-9.5c-1-1.5-.6-3.5.9-4.4 1.5-1 3.7-1.1 4.6.4l6.1 10c1 1.5.3 3.5-1.1 4.4-1.5.9-3.5.5-4.5-.9z"></path><path class="wrist1" d="M69.4 59.9L58.1 58c-1.7-.3-2.9-1.9-2.6-3.7.3-1.7 1.9-2.9 3.7-2.6l11.4 1.9c1.7.3 2.9 1.9 2.6 3.7-.4 1.7-2 2.9-3.8 2.6z"></path></g><g class="arm2"><path d="M34.2 43.6L45 40.3c1.7-.6 3.5.3 4 2 .6 1.7-.3 4-2 4.5l-10.8 2.8c-1.7.6-3.5-.3-4-2-.6-1.6.3-3.4 2-4z"></path><path class="wrist2" d="M27.1 56.2L32 45.7c.7-1.6 2.6-2.3 4.2-1.6 1.6.7 2.3 2.6 1.6 4.2L33 58.8c-.7 1.6-2.6 2.3-4.2 1.6-1.7-.7-2.4-2.6-1.7-4.2z"></path></g><g class="leg1"><path d="M52.1 73.2s-7-5.7-7.9-6.5c-.9-.9-1.2-3.5-.1-4.9 1.1-1.4 3.8-1.9 5.2-.9l7.9 7c1.4 1.1 1.7 3.5.7 4.9-1.1 1.4-4.4 1.5-5.8.4z"></path><path class="calf1" d="M52.6 84.4l-1-12.8c-.1-1.9 1.5-3.6 3.5-3.7 2-.1 3.7 1.4 3.8 3.4l1 12.8c.1 1.9-1.5 3.6-3.5 3.7-2 0-3.7-1.5-3.8-3.4z"></path></g><g class="leg2"><path d="M37.8 72.7s1.3-10.2 1.6-11.4 2.4-2.8 4.1-2.6c1.7.2 3.6 2.3 3.4 4l-1.8 11.1c-.2 1.7-1.7 3.3-3.4 3.1-1.8-.2-4.1-2.4-3.9-4.2z"></path><path class="calf2" d="M29.5 82.3l9.6-10.9c1.3-1.4 3.6-1.5 5.1-.1 1.5 1.4.4 4.9-.9 6.3l-8.5 9.6c-1.3 1.4-3.6 1.5-5.1.1-1.4-1.3-1.5-3.5-.2-5z"></path></g></svg>
                    <svg class="door" viewBox="0 0 100 100"><path d="M93.4 86.3H58.6c-1.9 0-3.4-1.5-3.4-3.4V17.1c0-1.9 1.5-3.4 3.4-3.4h34.8c1.9 0 3.4 1.5 3.4 3.4v65.8c0 1.9-1.5 3.4-3.4 3.4z"></path><circle cx="66" cy="50" r="3.7"></circle></svg>
                    <span class="button-text">Log Out</span>
                </button>
            </li>

            <style>
              /* assets/styles/admin_sidebar.css */

:root{
  --admin-sidebar-base-clr: #1e1e2d; /* Slightly different dark blue/purple */
  --admin-sidebar-line-clr: #36364a;
  --admin-sidebar-hover-clr: #2a2a3d;
  --admin-sidebar-text-clr: #e0e0e6;
  --admin-sidebar-accent-clr: #7a7dfa; /* Slightly different purple */
  --admin-sidebar-secondary-text-clr: #a0a3b1;
}

/* Adjust toggle button positioning within the sidebar */
#admin-sidebar > ul > li:first-child {
  display: flex;
  /* Changed justify-content to place button correctly */
  justify-content: flex-start; 
  margin-bottom: 16px;
}

#admin-sidebar ul li.active a {
  color: var(--admin-sidebar-accent-clr);
  /* Icons removed, so no fill change needed */
}

#admin-sidebar a, #admin-sidebar .logo {
  border-radius: .5em;
  padding: .85em;
  text-decoration: none;
  color: var(--admin-sidebar-text-clr);
  display: flex;
  align-items: center;
  gap: 1em;
}

/* No dropdowns needed */
/* .dropdown-btn { ... } */

/* Icons removed */
/* #admin-sidebar svg { ... } */

#admin-sidebar a span {
  flex-grow: 1;
}

#admin-sidebar a:hover {
  background-color: var(--admin-sidebar-hover-clr);
}

/* Sub menus removed */
/* #admin-sidebar .sub-menu { ... } */

/* Toggle button specific styles */
#admin-sidebar-toggle-btn {
  /* Removed margin-left: auto; */
  padding: 1em;
  border: none;
  border-radius: .5em;
  background: none;
  cursor: pointer;
  display: flex; /* Ensure SVG inside is aligned */
  align-items: center;
  justify-content: center;
  color: var(--admin-sidebar-text-clr); /* Make SVG color inherit */
}

#admin-sidebar-toggle-btn svg {
    fill: currentColor; /* Use text color for SVG */
    transition: rotate 150ms ease;
}

#admin-sidebar-toggle-btn:hover {
  background-color: var(--admin-sidebar-hover-clr);
}

#admin-sidebar-toggle-btn.rotate svg {
    /* Removed horizontal flip, rotation might not even be needed */
    /* transform: scaleX(-1); */
    /* Or use standard rotation: */
     rotate: 180deg; /* Re-enabled rotation */
}

/* Adjust main content padding if sidebar overlaps */
/* Example: Add padding-left to body or a main container when sidebar is open */
body.admin-sidebar-open {
    /* padding-left: 250px; /* Match sidebar width */
    /* transition: padding-left 300ms ease-in-out; */
}

/* Responsive styles removed for simplicity for now */
/* @media(max-width: 800px){ ... } */

/* Adjust icon fill color */
#admin-sidebar svg {
  flex-shrink: 0; /* Ensure icons don't shrink */
  fill: var(--admin-sidebar-text-clr); /* Use CSS variable for color */
}


/* Position logout item at the bottom */
/* REMOVED Flexbox rules from #admin-sidebar ul above */
#admin-sidebar ul li.logout-item {
    /* margin-top: auto; / / Removed */
    position: absolute;
    bottom: 15px; /* Position from bottom */
    left: 1em; /* Align with other items' padding */
    width: calc(100% - 2em); /* Adjust width based on padding */
     /* margin-bottom: 15px; / / Use bottom positioning instead */
}

/* Adjust logout button display when sidebar is closed */
#admin-sidebar.close ul li.logout-item {
    left: 5px; /* Match closed sidebar padding */
    width: calc(100% - 10px); /* Adjust width for closed state */
}

#admin-sidebar.close .logoutButton .button-text {
    display: none; /* Hide text when closed */
}

#admin-sidebar.close .logoutButton {
    width: 50px; /* Match icon area roughly */
    padding: 0; /* Remove padding */
    /* Center the icons */
    display: flex; 
    justify-content: center;
    align-items: center; 
}

#admin-sidebar.close .logoutButton svg {
    position: static; /* Override absolute positioning for centering */
}

/* Styles for Animated Logout Button */
.logoutButton {
    --figure-duration: 100ms;
    --transform-figure: none;
    --walking-duration: 100ms;
    --transform-arm1: none;
    --transform-wrist1: none;
    --transform-arm2: none;
    --transform-wrist2: none;
    --transform-leg1: none;
    --transform-calf1: none;
    --transform-leg2: none;
    --transform-calf2: none;

    background: none;
    border: 0;
    /* Use sidebar text color */
    color: var(--admin-sidebar-text-clr);
    cursor: pointer;
    display: block;
    font-family: inherit; /* Use sidebar font */
    font-size: 14px;
    font-weight: 500;
    height: 40px;
    outline: none;
    padding: 0 0 0 20px;
    perspective: 100px;
    position: relative;
    text-align: left;
    width: 130px;
    -webkit-tap-highlight-color: transparent;
    /* Ensure button is visible when sidebar is closed */
    overflow: visible;
}

.logoutButton::before {
    /* Use sidebar hover color for background? */
    background-color: var(--admin-sidebar-hover-clr);
    border-radius: 5px;
    content: '';
    display: block;
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    transform: none;
    transition: transform 50ms ease;
    width: 100%;
    z-index: 2;
}

/* Adjustments for dark theme - assuming these are the intended styles */
.logoutButton--dark .button-text {
    color: var(--admin-sidebar-text-clr); /* Match sidebar text */
}

.logoutButton--dark .door,
.logoutButton--dark .doorway {
    fill: var(--admin-sidebar-text-clr); /* Match sidebar text */
}

.logoutButton--dark .door path {
    /* Use sidebar accent color? */
    fill: var(--admin-sidebar-accent-clr); 
    stroke: var(--admin-sidebar-accent-clr);
    stroke-width: 4;
}

.logoutButton--dark .figure {
    /* Use sidebar accent color? */
    fill: var(--admin-sidebar-accent-clr);
}


.logoutButton:hover .door {
    transform: rotateY(20deg);
}

.logoutButton:active::before {
    transform: scale(.96);
}

.logoutButton:active .door {
    transform: rotateY(28deg);
}

.logoutButton.clicked::before {
    transform: none;
}

.logoutButton.clicked .door {
    transform: rotateY(35deg);
}

.logoutButton.door-slammed .door {
    transform: none;
    transition: transform 100ms ease-in 250ms;
}

.logoutButton.falling {
    animation: adminSidebarShake 200ms linear;
}

.logoutButton.falling .bang {
    animation: adminSidebarFlash 300ms linear;
}

.logoutButton.falling .figure {
    animation: adminSidebarSpin 1000ms infinite linear;
    bottom: -1080px; /* Keep large value */
    opacity: 0;
    right: 1px;
    transition: transform calc(var(--figure-duration) * 1ms) linear,
        bottom calc(var(--figure-duration) * 1ms) cubic-bezier(0.7, 0.1, 1, 1) 100ms,
        opacity calc(var(--figure-duration) * 0.25ms) linear calc(var(--figure-duration) * 0.75ms);
    z-index: 1;
}

.button-text {
    /* Already defined color via .logoutButton */
    font-weight: 500;
    position: relative;
    z-index: 10;
}

/* Ensure SVGs are positioned correctly relative to the button */
.logoutButton svg {
    display: block;
    position: absolute;
}

.figure {
    bottom: 5px;
    /* fill: #4371f7; Defined in .logoutButton--dark */
    right: 18px;
    transform: var(--transform-figure);
    transition: transform calc(var(--figure-duration) * 1ms) cubic-bezier(0.2, 0.1, 0.80, 0.9);
    width: 30px;
    z-index: 4;
}

.door,
.doorway {
    bottom: 4px;
    /* fill: #f4f7ff; Defined in .logoutButton--dark */
    right: 12px;
    width: 32px;
}

.door {
    transform: rotateY(20deg);
    transform-origin: 100% 50%;
    transform-style: preserve-3d;
    transition: transform 200ms ease;
    z-index: 5;
}

/* .door path fill/stroke defined in .logoutButton--dark */

.doorway {
    z-index: 3;
}

.bang {
    opacity: 0;
}

.arm1,
.wrist1,
.arm2,
.wrist2,
.leg1,
.calf1,
.leg2,
.calf2 {
    transition: transform calc(var(--walking-duration) * 1ms) ease-in-out;
}

.arm1 {
    transform: var(--transform-arm1);
    transform-origin: 52% 45%;
}

.wrist1 {
    transform: var(--transform-wrist1);
    transform-origin: 59% 55%;
}

.arm2 {
    transform: var(--transform-arm2);
    transform-origin: 47% 43%;
}

.wrist2 {
    transform: var(--transform-wrist2);
    transform-origin: 35% 47%;
}

.leg1 {
    transform: var(--transform-leg1);
    transform-origin: 47% 64.5%;
}

.calf1 {
    transform: var(--transform-calf1);
    transform-origin: 55.5% 71.5%;
}

.leg2 {
    transform: var(--transform-leg2);
    transform-origin: 43% 63%;
}

.calf2 {
    transform: var(--transform-calf2);
    transform-origin: 41.5% 73%;
}

            </style>