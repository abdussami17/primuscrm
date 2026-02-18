document.addEventListener("DOMContentLoaded", function () {
    flatpickr(".cf-datepicker", {
      altInput: true,                  // nicely formatted date
      altFormat: "M d, Y",             // Feb 12, 2026
      dateFormat: "Y-m-d",             // value stored in input
      allowInput: false,
      monthSelectorType: "dropdown",   // easy month select
      yearSelectorType: "dropdown",    // easy year select
      defaultDate: null
    });
  });