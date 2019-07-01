export  const jQScrollUp = () => $('body,html').animate({ scrollTop: 0});//por si necesitamos recurrir a esta función en otro lado, i.e. Vue

export const scrollUp = function(selector) {
	$(selector).on('click', jQScrollUp)
}