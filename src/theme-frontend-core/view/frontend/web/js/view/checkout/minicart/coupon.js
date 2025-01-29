define([
		'uiComponent',
		'jquery',
		'ko',
		'mage/storage',
		'Eloom_Core/js/model/url-builder'],
	function (Component,
	          $,
	          ko,
	          storage,
	          urlBuilder) {
		'use strict';

		let isComplete = $.Deferred();
		let totals = ko.observableArray([]);
		let data$ = null;

		return Component.extend({
			defaults: {
				template: 'Eloom_ThemeFrontendCore/checkout/minicart/coupon',
				couponCode: ko.observable(),
				validCouponCode: ko.observable(),
				message: ko.observable()
			},
			totals: totals,

			initialize: function () {
				let self = this;
				this._super();
				this.element = $('[data-block="minicart"]');
				this.setupAddToCartListener();

				return self;
			},

			setupAddToCartListener: function () {
				let self = this;

				this.element.on('dropdowndialogopen', function () {
					try {
						storage.post(
							urlBuilder.createUrl('/eloom/theme/discount', {}),
							null,
							false
						).done(function (response) {
							try {
								data$ = response;
								totals.removeAll();

								if (data$) {
									let json = JSON.parse(data$);
									if (json && json.code == '200') {
										self.validCouponCode(json.data.couponCode);
										self.couponCode(json.data.couponCode);

										_.each(json.data.totals, function (data, k) {
											if (!_.contains(totals, data)) {
												totals.push(data);
											}
										});
									}
								}
							} catch (e) {
								console.error(e);
							}
							isComplete.resolve();
						}).always(() => {
							isComplete.reject();
						});
					} catch (e) {

					} finally {
					}
				});
			},

			hasValidCouponCode: function () {
				return (this.validCouponCode() != null && this.validCouponCode() != '');
			},

			apply: function () {
				this.call(0);
			},

			cancel: function () {
				this.call(1);
			},

			call: function (remove) {
				let self = this;
				storage.post(
					urlBuilder.createUrl('/eloom/theme/coupon', {}),
					JSON.stringify({
						remove: remove,
						couponCode: self.couponCode()
					}),
					false
				).done(function (response) {
					data$ = response;
					try {
						totals.removeAll();
						self.message('');

						if (data$) {
							let json = JSON.parse(data$);
							if (json && json.code == '200') {
								self.validCouponCode(json.data.couponCode);

								if(json.data.message) {
									self.message(json.data.message);
								}
								_.each(json.data.totals, function (data, k) {
									if (!_.contains(totals, data)) {
										totals.push(data);
									}
								});
							}
						}
					} catch (e) {
						console.error(e);
					}
					isComplete.resolve();
				}).always(() => {
					isComplete.reject();
				});
			},
		});
	});