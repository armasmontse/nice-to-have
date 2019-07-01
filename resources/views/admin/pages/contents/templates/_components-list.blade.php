<ul class="collapsible popout row-mt" data-collapsible="accordion"  v-sortable="{onUpdate: onUpdate, onMove: onMove, handle: '.handle', group: label}" >
    <li v-for="component in sortable_list" >
        <div class="collapsible-header">
            <div class="pull-left" v-if="section.type.sortable && sortable_list.length > 1" >
                <span class="btn-floating waves-effect waves-light" @click.stop="move(-1, $index, sortable_list)">
                    <i class="fa fa-arrow-circle-up fa-2x" aria-hidden="true"></i>
                </span>
                <span class="btn-floating waves-effect waves-light" @click.stop="move(1, $index, sortable_list)">
                    <i class="fa fa-arrow-circle-down fa-2x" aria-hidden="true"></i>
                </span>
            </div>
            <div class="row row-mt align-input-icon">
                <div class="col-xs-2 routetd_JS" style="cursor: pointer;">
                    <i class="fa fa-eye fa-2x infoshow_JS " aria-hidden="true"></i>
                    <i class="fa fa-eye-slash fa-2x infoshow_JS hidden" aria-hidden="true"></i>
                </div>
                <div class="col-xs-10 text-left">
                    <h4  v-if="editing_title === false" v-text='component.index ? component.index : "Ponme un nombre" '   @click="editing_title = true"></h4>
                    <input v-else type="text"  v-model="component.index" @change="editing_title = false" @keyup.enter.prevent="editing_title = false" class="form-control input">
                </div>
            </div>
            <div class="row row-mt">
                <div class="col-xs-12">
                    <div class="pull-right" v-if="section.type.unlimited">
                        {!! Form::open([
                	      'method'				=> 'DELETE',
                	      'route'					=> ['admin::pages.sections.ajax.components.destroy','         &#123;&#123;section.id&#125;&#125;','&#123;&#123;component.id&#125;&#125;'],
                	      'role'					=> 'form' ,
                	      'id'					=> 'delete_compoment-&#123;&#123;component.id&#125;&#125;_form',
                	      'class'				=> '',
                	      'data-index'			=> '&#123;&#123;$index&#125;&#125;',
                	      'v-on:submit.prevent'	=> 'post'
                        ]) !!}

                	    <button type="submit" class="btn" form ="delete_compoment-&#123;&#123; component.id &#125;&#125;_form" @click.stop="">
                		    <i class="material-icons">Eliminar</i>
                	    </button>

                       {!!Form::close()!!}
                    </div>  
                </div>
            </div>
        </div>
        <div class="collapsible-body infoshow_JS hidden">
            <component-form
            :section="section"
            :component= "component"
            :index="index"
            :component-name="component.index"
            ></component-form>
        </div>
    </li>
</ul>

<div v-if="list.length == 0">
    Seccion vacía 
</div>

