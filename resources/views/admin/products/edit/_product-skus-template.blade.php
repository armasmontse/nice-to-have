<script type="x/templates" id="product-skus-template">
	<div class="row">
		<div class="col-xs-12">
			<a class="link-as-button pull-right" href="#" data-toggle="modal" data-target="#sku-create">Agregar sku</a>
		</div>

		<div class="col-xs-12">
			<table class="table" v-if="!list">
				<thead class="text__p text__p-table-head">
					<tr>
						<th>Sku</th>
						<th></th>
						<th>Descripción</th>
						<th class="text-center" >Editar</th>
						<th class="text-center" >Desactivar</th>
					</tr>
				</thead>
			</table>
			<table class="table" v-else>
				<thead class="text__p text__p-table-head">
					<tr>
						<th>Sku</th>
						<th></th>
						<th>Descripción</th>
						<th class="text-center" >Editar</th>
						<th class="text-center" >Desactivar</th>
					</tr>
				</thead>
				<tbody class="text__p">
					<tr is="single-sku"
						v-for="product_sku in list"
						:index="$index"
						:list.sync="list"
						v-ref:list
						:sku="product_sku"
						:ref-path="['$root', '$refs', 'product_skus', '$refs', 'list', $index]"
						:current-image="product_sku.thumbnail_image"
						:photoable-id="product_sku.sku"
						:photoable-type="'sku'"
						:use="'thumbnail'"
						:class="''"
						:default-order="'null'"
					>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</script>
