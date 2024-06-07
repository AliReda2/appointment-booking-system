
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll('.navbar button');
    const selector = document.querySelector('.selector');
    let originalOffsetX = selector.offsetLeft;

    buttons.forEach(button => {

        button.addEventListener('click', function () {

            const buttonRect = button.getBoundingClientRect();
            const selectorRect = selector.getBoundingClientRect();
            const buttonCenterX = buttonRect.left + buttonRect.width / 2;
            const currentSelectorCenterX = selectorRect.left + selectorRect.width / 2;
            let offsetX = buttonCenterX - currentSelectorCenterX;

            // Adjust offsetX to keep the selector within the screen bounds
            const minOffsetX = -selectorRect.left; // Prevent moving left of screen
            const maxOffsetX = window.innerWidth - selectorRect.right; // Prevent moving right of screen
            offsetX = Math.max(minOffsetX, Math.min(offsetX, maxOffsetX));

            // Update originalOffsetX for subsequent calculations
            originalOffsetX += offsetX;

            selector.style.transform = `translateX(${originalOffsetX}px)`;
            // selector.style.zIndex = 1; // Move selector to top

            // Remove class 'active' from all buttons
            buttons.forEach(btn => btn.classList.remove('active'));
            // Add class 'active' to clicked button
            button.classList.add('active');
        });
    });
});



function toggleMainContent(mainIdToShow, clickedButton) {
    // Remove 'active' class from all buttons
    const allButtons = document.querySelectorAll('.navbar .nav-button');
    allButtons.forEach(button => {
        button.classList.remove('active');
    });

    // Add 'active' class to the clicked button
    clickedButton.classList.add('active');

    // Hide all main sections
    const allMainSections = document.querySelectorAll('main');
    allMainSections.forEach(section => {
        section.style.display = 'none';
    });

    // Show the selected main section
    const mainToShow = document.getElementById(mainIdToShow);
    if (mainToShow) {
        mainToShow.style.display = 'block';
    } else {
        console.error("Element with ID " + mainIdToShow + " not found.");
    }
}
