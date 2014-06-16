$(document).ready(function() {
    // Initialize navgoco with default options
    $("#demo1").navgoco({
        caret: '<span class="caret"></span>',
        accordion: false,
        openClass: 'open',
        save: true,
        cookie: {
            name: 'navgoco',
            expires: false,
            path: '/'
        },
        slide: {
            duration: 150,
            easing: 'swing'
        }
    });

    $("#collapseAll").click(function(e) {
        e.preventDefault();
        $("#demo1").navgoco('toggle', false);
    });

    $("#expandAll").click(function(e) {
        e.preventDefault();
        $("#demo1").navgoco('toggle', true);
    }); 
});
