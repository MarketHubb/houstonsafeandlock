<?php if (isset($args)) { ?>
	<div class="" id="featured-safe-home">
		<div class="container bg-blue px-3 py-4 my-4 rounded-3">
			<div class="row ms-0 me-0 bg-white rounded-3 shadow px-4 py-5 row-cols-<?php echo count($args); ?>">

				<?php if (count($args) <= 2) { ?>

					<?php foreach ($args as $featured) { ?>

						<?php
						$safe = get_post($featured);
						$fields = get_field('featured_safe', $featured);
						$image = wp_get_attachment_image_src(get_post_thumbnail_id($featured), 'full');
						$feature_type = ($fields['feature_type'] === "Sale") ? "Sale" : "Featured";
						?>
						<div class="featured">
							<div class="row d-flex align-items-center">
								<div class="col-md-8">
									<span class="bg-orange rounded-pill tracking-wide fw-semibold text-white px-2 small mb-4 d-inline-block"><?php echo $feature_type; ?></span><br>

									<?php if ($fields['sale_type'] === 'Discount (Percentage)') { ?>
										<?php
										$msrp_raw = (float) get_field('post_product_gun_msrp', $featured);
										$msrp = formatMoney($msrp_raw);
										$discount_type = "percentage";
										$discount_amount = $fields['discount_percentage'];
										$sale_price = discounted_price($msrp_raw, $discount_type, $discount_amount);
										?>
										<h4 class="fw-semibold d-inline-block pe-1"><?php echo $sale_price; ?></h4>
										<h4 class="lead text-secondary d-inline-block text-decoration-line-through mb-3"><?php echo $msrp; ?></h4>

									<?php } ?>

									<h4 class="text-blue"><?php echo $fields['heading']; ?></h4>

									<?php if ($fields['subheading']) : ?>
										<h5 class="text-secondary fw-normal d-inline-block mb-3"><?php echo $fields['subheading'] ?></h5>
									<?php endif ?>

									<p class="fw-400 mb-0 lh-base"><?php echo $fields['description']; ?></p>

									<?php if ($fields['callout']) : ?>
										<div class="border-top border-1 border-light mt-3 pt-3">
											<p class="fw-600 fst-italic mb-0 lh-base"><?php echo $fields['callout']; ?></p>
										</div>
									<?php endif ?>

									<?php
									$cta_text = 'Request the ' . get_the_title($featured);
									$btn_classes = "btn btn-primary bg-orange fw-600 rounded-3 shadow-sm font-source border-1 py-2 px-3 mt-5";
									?>


									<a class="d-inline-block mt-4 lead fw-500" href="<?php echo get_permalink($featured); ?>">Learn more &#8594;</a>

									<?php //echo get_product_inquiry_btn($featured, $cta_text, null, $btn_classes); 
									?>
								</div>
								<div class="col-md-4 text-center">
									<img class="featured-img-home d-inline-block" src="<?php echo $image[0]; ?>" alt="">
								</div>
							</div>
						</div>

					<?php } ?>

				<?php } ?>


			</div>
		</div>

	</div>
<?php } ?>