document.getElementById('productCategory').addEventListener('change', function(){
    const category = this.value;
    const selectProductName = document.getElementById('productName');

    selectProductName.innerHTML = '<option value="" disabled selected>Select Product</option>';

    const products = {
        'hardBoiledCandy' : ['Lemon Sherbet', 'Humbug'],
        'gummyCandy': ['Cola Bottle'], 
        'lollipops' : ['Watermelon'],
        'nerds' : ['Grape and Strawberry'],
        'sourCandy' : ['Rainbow Twists']
    };

    //only displays the options that fall within the selected product category 
    if (products[category]) {
        products[category].forEach(function(product) {
            const option = document.createElement('option');
            option.value = product.toLowerCase().replace(/ /g, '');
            option.text = product;
            selectProductName.add(option);
        });
    }
});
