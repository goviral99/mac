//helper function for getting 
function getValue(id) {
    const value = document.getElementById(id).value;
    if (value === "" || isNaN(value)) {
        return 0;
    } else {
        return parseFloat(value);
    }
}

function calculate() {
    // The price of about 3oz of gold
    const nisab_amount = 7497.03;

    // Assets
    const cash_amount = getValue("cash_amount");
    const value_of_gold = getValue("value_of_gold");
    const value_of_silver = getValue("value_of_silver");
    const other_savings = getValue("other_savings");
    const RRSP_RESP_savings = getValue("RRSP_RESP_savings");
    const money_owed_to_you = getValue("money_owed_to_you");
    const stock_share_values = getValue("stock_share_values");

    // Liabilities
    const money_you_owe = getValue("money_you_owe");
    const personal_expenses = getValue("personal_expenses");
    const business_expenses = getValue("business_expenses");
    const other_outgoing_dues = getValue("other_outgoing_dues");

    // The sum of all of your different assets that you've had for the last
    // lunar year
    const total_gross_assets = cash_amount + value_of_gold + value_of_silver + other_savings + money_owed_to_you + RRSP_RESP_savings + stock_share_values;

    // The sum of all of your different liabilities
    const total_net_liabilities = money_you_owe + personal_expenses + business_expenses + other_outgoing_dues;

    // Gross assets minus the liabilities you have. Again these are typically
    // immediate liabilities. Not the totality of a large loan like a mortgage
    const total_net_assets = total_gross_assets - total_net_liabilities
    let eligable_amount = 0;

    // If this net amount is bigger than the nisab, then it's eligible
    // to have Zakat assessed against it
    if (total_net_assets > nisab_amount) {
        eligable_amount = Math.ceil(total_net_assets);
    }

    // Zakat is 2.5% of ones eligible wealth if it above Nisab
    const zakat_amount = Math.ceil(eligable_amount * .025);

    const formatter = new Intl.NumberFormat('en-CA', {
        style: 'currency',
        currency: 'CAD',
    });

    // Write the total values back for the user
    document.getElementById("main-zakat-net-assets-number").innerText = formatter.format(total_net_assets);
    document.getElementById("main-zakat-nisab-threshold-amount").innerText = formatter.format(nisab_amount);
    document.getElementById("main-zakat-total-amount-number").innerText = formatter.format(zakat_amount);
}

function handleReset() {
    // Reset All Values
    document.getElementById("cash_amount").value = ""
    document.getElementById("value_of_gold").value = ""
    document.getElementById("value_of_silver").value = ""
    document.getElementById("other_savings").value = ""
    document.getElementById("RRSP_RESP_savings").value = ""
    document.getElementById("money_owed_to_you").value = ""
    document.getElementById("stock_share_values").value = ""

    document.getElementById("money_you_owe").value = ""
    document.getElementById("personal_expenses").value = ""
    document.getElementById("business_expenses").value = ""
    document.getElementById("other_outgoing_dues").value = ""

    calculate()
}