<div class="shop__filter-group shop__filter-group_JS">

	<div>
		<h2 class="shop__ttl shop__ttl--sidebar shop__ttl--small">{{$title}}</h2>
		<div class="divisor shop__divisor"></div>
		<h3 class="shop__ttl shop__ttl--filter"
			v-if="('{{$kind_singular}}' === 'type' && store.is_event_shop)"
			v-text="store.current_event.typeable.label">
		</h3>
	</div>

{{--
$kind_singular puede ser category o type
$kind_plural puede ser categories o types
 --}}
{{-- Modelo
 <div class="relative" v-for="filter_group in store.{{$kind_plural}}.data">
	<h1 v-text="filter_group.label"></h1>
	<div v-for="filter in filter_group.sub{{$kind_plural}}">
		<h2><b v-text="filter.label"></b></h2>
	</div>
 </div>
  --}}

	<div v-if="!('{{$kind_singular}}' === 'type' && store.is_event_shop)">
		<div class="relative" v-for="{{$kind_singular}} in store.{{$kind_plural}}.data">
			<h3 class="shop__ttl shop__ttl--filter toplevel_JS shop__ttl--filter--small">
				&#123;&#123;{{$kind_singular}}.label&#125;&#125;
					{!! file_get_contents('images/flecha-select--flippable.svg') !!}
			</h3>
			<div class="sublevel_JS" style="display:none">{{-- para que sirva el last-of-type de shop__checkbox-container --}}
				<div class="input__checkbox-container shop__checkbox-container">
					<label class="input__checkbox-label shop__checkbox-label--todos"
						@click.self="toggleSelectionOnAllParentCheckboxes('{{$kind_singular}}', '{{$kind_plural}}', {{$kind_singular}}.id )">
						Todos
					</label>
				</div>
				<div class="input__checkbox-container shop__checkbox-container"
					v-for="sub{{$kind_singular}} in {{$kind_singular}}.sub{{$kind_plural}}">
					<input
						type="checkbox"
						class="input__checkbox shop__checkbox"
						:id="{{$kind_singular}}.label +'__'+sub{{$kind_singular}}.label"
						:value="sub{{$kind_singular}}.id"
						v-model="selected_sub{{$kind_plural}}"
					>
						{{-- :for="{{$kind_singular}}.label+'__'+sub{{$kind_plural}}_by_id[sub{{$kind_singular}}_id].label" --}}
					<label
						:for="{{$kind_singular}}.label +'__'+sub{{$kind_singular}}.label"
						class="input__checkbox-label shop__checkbox-label">
						&#123;&#123;sub{{$kind_singular}}.label&#125;&#125;
					</label>
				</div>
			</div>
		</div>
	</div>


</div>
