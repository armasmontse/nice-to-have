<div class="row">
    <div class="col-xs-12">
        <a class="link-as-button pull-right" href="#" data-toggle="modal" data-target="#related-products-modal-create">relacionar un producto</a>
    </div>

    <related-products :products="store.products.data" :related-products-ids="store.related_products_ids"></related-products>
    <script type="x/templates" id="related-products-template">
        <div>
            <div v-if="relatedProductsIds.length <= 0 && products.length <= 0" class="text-center">
                <h2 class="loading-text text__p">Esperando productos para relacionar...</h2>
                @include('client.general.loading-icon')
            </div>
            <div v-else>
                <h1 v-if="related_products.length === 0" class="text-center loading-text text__p">Cargando...</h1>
                <div v-else class="col-xs-4" :title="product.title" v-for="product in related_products">
                    <div class="placeholders">
                        <h3 v-text="product.title" class="text-overflow-ellipsis text__p"></h3>
                        <img class="img-thumnbnail" :alt="product.img_alt" :src="product.img_url">
                    </div>
                </div>
            </div>
        </div>
    </script>
</div>
