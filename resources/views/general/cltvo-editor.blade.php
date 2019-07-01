<script type="x/templates" id="cltvo-editor-template">
	<div class="">
		<label :for="name" class="input-label active" v-text="label" v-if="label"></label>
		<br>
		<v-editor :content.sync='value_'></v-editor>
		<input type="hidden" v-model="value_" :name="name" :form ="form">
	</div>
</script>
