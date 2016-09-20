$(document).ready(function() {
    var displayProfiler = Cookies.set("ti_displayProfiler"),
        displayProfilerSections = Cookies.set("ti_displayProfilerSections"),
        displayProfilerTab = Cookies.set("ti_displayProfilerTab");

    $("#codeigniter_profiler").on("click", ".btn-profiler", function() {
        if($("#codeigniter_profiler .profiler").is(":visible")) {
            $("body").removeClass("ti_profiler_bar");
            $("#codeigniter_profiler .profiler").fadeOut();
            displayProfiler = "false";
        } else {
            $("body").addClass("ti_profiler_bar");
            $("#codeigniter_profiler .profiler").fadeIn();
            displayProfiler = "true";
        }
        Cookies.set("ti_displayProfiler", displayProfiler);
    });

    if (displayProfiler == "true") $("#codeigniter_profiler .profiler").fadeIn();

    $("#codeigniter_profiler .profiler-menu").on("click", ".btn-collapse, li.active > a", function() {
    // $("#codeigniter_profiler .btn-collapse").on("click", function() {
        var $sections = $("#codeigniter_profiler .profiler .profiler-sections");
        if ($sections.is(":visible")) {
            $sections.fadeOut();
            $('#codeigniter_profiler .btn-collapse').find(".fa").removeClass("fa-chevron-down").addClass("fa-chevron-up");
            displayProfilerSections = "false";
        } else {
            $sections.fadeIn();
            $('#codeigniter_profiler .btn-collapse').find(".fa").removeClass("fa-chevron-up").addClass("fa-chevron-down");
            displayProfilerSections = "true";
        }
        Cookies.set("ti_displayProfilerSections", displayProfilerSections);
    });

    if (displayProfilerSections == "true") $("#codeigniter_profiler .btn-collapse").trigger('click');

    $("#codeigniter_profiler .profiler-menu a").on("shown.bs.tab", function (e) {
        Cookies.set("ti_displayProfilerTab", "#"+$(e.target).attr("id"));
        return false;
    });

    if (displayProfilerTab) $(displayProfilerTab).tab("show");
});