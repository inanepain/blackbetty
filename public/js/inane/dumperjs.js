/**
 * Dumper Wrapper
 *
 * Loading dumper as a script
 */
(async () => {
    // Check for a global Dumper object
    if (window.Dumper == undefined) {
        // import module for side effects, global Dumper created
        const response = await import(`/js/inane/dumper.js`);
        window.Dumper = response.Dumper;
    }
})();
