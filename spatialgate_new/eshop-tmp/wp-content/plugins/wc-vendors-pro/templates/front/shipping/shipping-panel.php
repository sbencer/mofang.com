<?php
/**
 * The Template for displaying the product shipping details
 *
 * Override this template by copying it to yourtheme/wc-vendors/front/shipping
 *
 * @package    WCVendors_Pro
 * @version    1.2.3
 */
?>


<h2>Shipping Details</h2>

<p>
<strong>Shipping From: </strong> <?php echo $countries[ strtoupper( $store_country ) ]; ?>
</p>

<?php if ( ! empty( $shipping_flat_rates ) ) :  ?>

	<?php if ( ! empty( $shipping_flat_rates[ 'national' ] ) || ! empty( $shipping_flat_rates[ 'international' ] ) || ( array_key_exists( 'national_free', $shipping_flat_rates ) && $shipping_flat_rates[ 'national_free' ] == 'yes' ) || ( array_key_exists( 'international_free', $shipping_flat_rates ) && $shipping_flat_rates[ 'international_free' ] == 'yes' ) ) :  ?>

	<table>

	<?php if ( $shipping_flat_rates[ 'national_disable' ] !== 'yes' ): ?> 
		<?php if ( strlen( $shipping_flat_rates[ 'national' ] ) >= 0 || strlen( $shipping_flat_rates[ 'national_free' ] ) >= 0 ) : ?>
			<?php $free = ( array_key_exists( 'national_free', $shipping_flat_rates ) && $shipping_flat_rates[ 'national_free' ] == 'yes' ) ? true : false; ?> 
			<?php $price = $free ? __( 'Free', 'wcvendors-pro' ) : wc_price( $shipping_flat_rates[ 'national' ] . $product->get_price_suffix() ); ?> 
			<tr>
				<td width="60%"><strong>Within <?php echo $countries[ strtoupper( $store_country ) ]; ?></strong></td>
				<td width="40%"><?php echo $price; ?></td>
			</tr>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( $shipping_flat_rates[ 'international_disable' ] !== 'yes' ):  ?>
		<?php if ( strlen( $shipping_flat_rates[ 'international' ] ) > 0 || strlen( $shipping_flat_rates[ 'international_free' ] ) > 0 ) : ?>
			<?php $free = ( array_key_exists( 'international_free', $shipping_flat_rates ) && $shipping_flat_rates[ 'international_free' ] == 'yes' ) ? true : false; ?> 
			<?php $price = $free ? __( 'Free', 'wcvendors-pro' ) : wc_price( $shipping_flat_rates[ 'international' ] . $product->get_price_suffix() ); ?> 
			<tr>
				<td width="60%"><strong>Outside <?php echo $countries[ strtoupper( $store_country ) ]; ?></strong></td>
				<td width="40%"><?php echo $price; ?></td>
			</tr>
		<?php endif; ?>
	<?php endif; ?>
	</table>

	<?php else: ?>

	<h5><?php _e( 'No shipping rates are available for this product.', 'wcvendors-pro' ); ?></h5>

	<?php endif; ?>

<?php else: ?>

	<?php if ( ! empty( $shipping_table_rates ) ):  ?>

		<table>

		<thead>
			<tr>
				<th><?php _e( 'Country', 'wcvendors-pro' ); ?></th>
				<th><?php _e( 'State', 'wcvendors-pro' ); ?></th>
				<th><?php _e( 'Cost', 'wcvendors-pro' ); ?></th>
			</tr>
		</thead>
		<?php foreach( $shipping_table_rates as $rate ):  ?>

		<tr>
			<td width="40%"><?php echo ( $rate[ 'country' ] != '' ) ? $countries[ strtoupper( $rate['country'] ) ] : __( 'Any', 'wcvendors-pro' ); ?></td>
			<td width="40%"><?php echo ( $rate[ 'state' ] != '' ) ? $rate['state'] : __( 'Any', 'wcvendors-pro' ); ?></td>
			<td width="20%"><?php echo wc_price( $rate['fee'] . $product->get_price_suffix() );  ?></td>
		</tr>
		<?php endforeach; ?>

		</table>	

	<?php else: ?>

		<?php if ( ! empty( $shipping_flat_rates ) ):  ?>

			<table>
			<tr>
				<td width="60%"><strong>Within <?php echo $countries[ strtoupper( $store_country ) ]; ?></strong></td>
				<td width="40%"><?php echo wc_price( $shipping_flat_rates[ 'national' ] . $product->get_price_suffix() );  ?></td>
			</tr>
			<tr>
				<td width="60%"><strong>Outside <?php echo $countries[ strtoupper( $store_country ) ]; ?></strong></td>
				<td width="40%"><?php echo wc_price( $shipping_flat_rates[ 'international' ] . $product->get_price_suffix() );  ?></td>
			</tr>
			</table>

		<?php else: ?>

		<h5><?php _e( 'No shipping rates are available for this product.', 'wcvendors-pro' ); ?></h5>

		<?php endif; ?>

	<?php endif; ?>

<?php endif; ?>


<?php if ( is_array( $store_rates ) &&  array_key_exists( 'shipping_policy', $store_rates ) && $store_rates[ 'shipping_policy' ] != '' ):  ?>
<h3>Shipping Policy</h3>
<p>
<?php echo $store_rates[ 'shipping_policy' ]; ?>
</p>
<?php endif; ?>


<?php if ( is_array( $store_rates ) && array_key_exists( 'return_policy', $store_rates ) && $store_rates[ 'return_policy' ] != '' ):  ?>
<h3>Return Policy</h3>

<p>
<?php echo $store_rates[ 'return_policy' ]; ?>
</p>

<?php endif; ?>