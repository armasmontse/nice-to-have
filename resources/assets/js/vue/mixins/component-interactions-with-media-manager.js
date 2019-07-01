export var componentInteractionsWithMediaManager = {
	methods: {
		initAddMediaProcess(media_manager_ref) {
			this.$parent.$refs.media_manager.active_calling_component_ref = this.$options._ref;
			this.$parent.$refs.media_manager.open();
		},
	}
};
