crud.field('type').onChange(function (input) {
    dealWithIncomeAndExpense();
}).change();

crud.field('transactionCategory').onChange(function (input) {
    // Is a tuition
    if (input.value === '3') {
        crud.field('customer').hide();
        crud.field('vendor').hide();

        crud.field('student').show();

        return;
    }

    crud.field('student').hide();
    dealWithIncomeAndExpense();
}).change();

function dealWithIncomeAndExpense() {
    if (crud.field('type').input.value === 'INCOME') {
        crud.field('customer').show();
        crud.field('vendor').hide();

        return;
    }

    if (crud.field('type').input.value === 'EXPENSE') {
        crud.field('customer').hide();
        crud.field('vendor').show();

        return;
    }

    crud.field('customer').hide();
    crud.field('vendor').hide();
}
