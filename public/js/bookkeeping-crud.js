crud.field('type').onChange(function (input) {
    if (input.value === 'INCOME') {
        crud.field('customer').show();
        crud.field('vendor').hide();

        return;
    }

    if (input.value === 'EXPENSE') {
        crud.field('customer').hide();
        crud.field('vendor').show();

        return;
    }

    crud.field('customer').hide();
    crud.field('vendor').hide();
}).change();
