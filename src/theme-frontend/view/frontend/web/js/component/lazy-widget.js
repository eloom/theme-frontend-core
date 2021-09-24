define([
	'jquery'
], function ($) {
	return function (config, element) {
		let self = this;
		const targets = document.querySelectorAll("[data-eloom-widget]");

		const lazyLoad = (target) => {
			const io = new IntersectionObserver((entries, observer)  => {
				entries.forEach(entry => {
					try {
						if (entry.isIntersecting && !entry.isVisible) {
							const widget = entry.target;
							const uri = widget.getAttribute("data-uri");
							const params = widget.getAttribute("data-params");

							$.ajax({
								url: uri,
								type: "POST",
								data: JSON.parse(params ? params : ''),
								showLoader: false
							}).done(function (response) {
								$(widget).html(response.output).trigger('contentUpdated');
							}).fail(
							);

							observer.disconnect();
						}
					} catch (e) {
						console.error(e);
					}
				})
			});

			io.observe(target);
		}

		targets.forEach(lazyLoad);
	}
});