/**
 * An object that creates a switch that allows the exectution of one of multiple functions depending on the state of a external variable.
 * @param {object} options k:v pairs for the switch options and its values
 */
export var Switch = function(options) {
	this.options = options;
};

Switch.of = function(options) {
	return new Switch(options);
};

Switch.prototype.isFunction = function(state) {
	return typeof this.options[state] === 'function';
};

Switch.prototype.isSomething = function(state) {
	return this.options[state] !== null && this.options[state] !== undefined;
};

Switch.prototype.run = function(state) {
	return this.isFunction(state) 	? 
									this.options[state]() : 
									this.isSomething(state) ? 
															this.options[state] : 
															null;
};