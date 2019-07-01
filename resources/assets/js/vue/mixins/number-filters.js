export var numberFilters = {
	filters: {
		parseInt(str_num) {
			return parseFloat(str_num);
		},

		parseQuantity(num) {
			return num.toLocaleString('en-US', {minimumFractionDigits: 0});
		},

		parseMoney(num) {
			num = parseFloat(num);
			return '$ ' + (num.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
		},

		parsePercentage(num) {
			num = parseFloat(num);
			return (num.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')) + '%';
		}
	}
};
