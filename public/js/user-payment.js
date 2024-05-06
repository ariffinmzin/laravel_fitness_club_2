document.addEventListener('DOMContentLoaded', () => {
    document
        .getElementById('payment_plan_id')
        .addEventListener('change', (e) => {
            let today = new Date();

            let isoDate = today.toISOString().slice(0, 10); // Get ISO formatted date (YYYY-MM-DD)

            let amount_input = document.getElementById('amount');
            let new_expiry_input = document.getElementById('new_expiry');
            let expiry_input = document.getElementById('expire_on');
            let expiry_date = null;
            if (expiry_input === null) {
                expiry_date = isoDate;
            } else {
                expiry_date = expiry_input.value;
            }

            let plan_id = e.target.value;
            if (plan_id == 'custom') {
                amount_input.readOnly = false;
                new_expiry_input.readOnly = false;
                new_expiry_input.value = '';
                amount_input.value = '0.01';
            } else {
                if (plan_id != '') {
                    amount_input.readOnly = true;
                    new_expiry_input.readOnly = true;
                    amount_input.value = js_plans[plan_id].price;

                    new_expiry_input.value = updateDate(
                        expiry_date,
                        js_plans[plan_id].duration
                    );
                }
            }
        });
});

function updateDate(date, duration) {
    // Convert the date string to a Date object
    let startDate = new Date(date);

    // Get today's date
    let today = new Date();

    // If the start date is not a valid date, set it to today
    if (!(startDate instanceof Date && !isNaN(startDate.getTime()))) {
        startDate = today;
    }
    console.log(today);

    // If the start date is in the past, start from today
    if (startDate < today) {
        startDate = today;
    }

    // Determine the additional duration based on the selected option
    switch (duration) {
        case '1 day':
            startDate.setDate(startDate.getDate() + 1);
            break;
        case '1 week':
            startDate.setDate(startDate.getDate() + 7);
            break;
        case '1 month':
            // Get the current month
            let currentMonth = startDate.getMonth();
            // Add 1 month
            startDate.setMonth(currentMonth + 1);
            break;
        case '3 months':
            // Get the current month
            let currentMonth3 = startDate.getMonth();
            // Add 3 months
            startDate.setMonth(currentMonth3 + 3);
            break;
        case '6 months':
            // Get the current month
            let currentMonth6 = startDate.getMonth();
            // Add 6 months
            startDate.setMonth(currentMonth6 + 6);
            break;
        case '1 year':
            // Get the current year
            let currentYear = startDate.getFullYear();
            // Add 1 year
            startDate.setFullYear(currentYear + 1);
            break;
        default:
            break;
    }
    console.log(startDate);

    let year = startDate.getFullYear();
    let month = String(startDate.getMonth() + 1).padStart(2, '0'); // Add leading zero if month is single digit
    let day = String(startDate.getDate()).padStart(2, '0'); // Add leading zero if day is single digit

    return `${year}-${month}-${day}`;
}
