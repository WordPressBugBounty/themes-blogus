document.addEventListener('DOMContentLoaded', function() {
    
    // Variables
    const body = document.body;
    
    // 1. Mouse Movement: Update CSS Variables
    // We rely on CSS to do the actual moving (transform)
    document.addEventListener('mousemove', function(e) {
        body.style.setProperty('--cursor-x', e.clientX + 'px');
        body.style.setProperty('--cursor-y', e.clientY + 'px');
    });

    // 2. Link Hovering Logic (Pointer Effect)
    // Select all interactive elements
    const links = document.querySelectorAll('a, button, .btn, input[type="submit"], input[type="button"], .elementor-button, .bs-like-btn, .switch .slider');

    links.forEach(function(link) {
        
        // On Enter: Add class to Body
        link.addEventListener('mouseenter', function() {
            body.classList.add('blogus-cursor-hover');
        });

        // On Leave: Remove class from Body
        link.addEventListener('mouseleave', function() {
            body.classList.remove('blogus-cursor-hover');
        });
    });

    // 3. Fix: Handle if mouse leaves the window (Optional)
    document.addEventListener('mouseout', function(e) {
        if (!e.relatedTarget && !e.toElement) {
             // Hide cursor if it leaves the browser window
            body.style.setProperty('--cursor-x', '-100px');
            body.style.setProperty('--cursor-y', '-100px');
        }
    });
});