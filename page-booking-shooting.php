<?php

/**
 * Template Name: Booking Shooting Page
 * Template Post Type: page
 *
 * @package a_m_theme
 */

$page_id = get_the_ID();

$page_fields = get_page_fields( $page_id );

$footer_section = $page_fields['Footer Section'] ?? array();

get_template_part( 'parts/header-default', '', array( 'shooting_booking_page' => true ) );

?>

<section
	class="booking-shooting-section"
	id="shooting-appoinment-booking-section"
	data-testid="booking-shooting-form"
	x-data="bookingForm"
	x-cloak>
	<template x-if="isSuccess">
		<div class="success-box" data-testid="booking-step-finished">
			<h3>Deine Anfrage ist eingegangen.</h3>
			<p>Du wirst innerhalb der nächsten 48 Stunden von mir hören, bis bald!</p>
			<h4 x-show="redirectNotice">Du wirst nun auf die Hauptseite weitergeleitet!</h4>
		</div>
	</template>

	<form
		class="booking-form"
		x-show="!isSuccess"
		@submit="submit"
		novalidate
		data-testid="booking-form">
		<p x-show="loadingShootings" class="font-lato-regular">Shootings werden geladen…</p>
		<p x-show="submitError" class="status-error" x-text="submitError" data-testid="submit-error"></p>

		<!-- Shooting -->
		<fieldset data-testid="booking-step-shootings">
			<legend>Welches Fotoshooting interessiert dich?</legend>
			<div class="field">
				<label for="shooting">Fotoshooting</label>
				<select
					id="shooting"
					name="shooting"
					x-model="booking.productId"
					@change="onShootingChange"
					data-testid="shooting-select"
					required
					:disabled="loadingShootings">
					<option value="">Bitte wählen…</option>
					<template x-for="shooting in shootings" :key="shooting.product_id">
						<option
							:value="shooting.product_id"
							x-text="shooting.title"></option>
					</template>
				</select>
				<p
					class="error"
					data-error-for="booking.productId"
					x-show="error('booking.productId') || error('booking.title')"
					x-text="error('booking.productId') || error('booking.title')"></p>
			</div>
		</fieldset>

		<!-- Customer -->
		<fieldset data-testid="booking-step-customer">
			<legend>Deine Daten</legend>
			<div class="field-row">
				<div class="field">
					<label for="firstName">Vorname&nbsp;*</label>
					<input
						id="firstName"
						name="firstName"
						type="text"
						autocomplete="given-name"
						x-model="customer.firstName"
						data-testid="firstName"
						required />
					<p class="error" data-error-for="customer.firstName" x-show="error('customer.firstName')" x-text="error('customer.firstName')"></p>
				</div>
				<div class="field">
					<label for="lastName">Nachname&nbsp;*</label>
					<input
						id="lastNameName"
						name="lastNameName"
						type="text"
						autocomplete="given-name"
						x-model="customer.lastName"
						data-testid="lastName"
						/>
					<p class="error" data-error-for="customer.lastName" x-show="error('customer.lastName')" x-text="error('customer.lastName')"></p>
				</div>
				<div class="field">
					<label for="email">E-Mail&nbsp;*</label>
					<input
						id="email"
						name="email"
						type="email"
						autocomplete="email"
						x-model="customer.email"
						data-testid="e-mail"
						required />
					<p class="error" data-error-for="customer.email" x-show="error('customer.email')" x-text="error('customer.email')"></p>
				</div>
				<div class="field">
					<label for="mobilePhone">Tel.&nbsp;Nummer&nbsp;*</label>
					<input
						id="mobilePhone"
						name="mobilePhone"
						type="tel"
						autocomplete="tel"
						x-model="customer.mobilePhone"
						data-testid="mobile-phone" />
					<p class="error" data-error-for="customer.mobilePhone" x-show="error('customer.mobilePhone')" x-text="error('customer.mobilePhone')"></p>
				</div>

			</div>

			<div class="field">
				<label for="message">Nachricht</label>
				<textarea
					id="message"
					name="message"
					type="text"
					x-model="customer.message"
					size="80"
					data-testid="message">

				</textarea>
				<p class="error" data-error-for="customer.message" x-show="error('customer.message')" x-text="error('customer.message')"></p>
			</div>

			<!-- Honeypot -->
			<div class="hp-field" aria-hidden="true">
				<label for="web-traffic-nm">Website Traffic Numbers</label>
				<input
					id="web-traffic-nm"
					name="honeyPot"
					type="text"
					tabindex="-1"
					autocomplete="off"
					x-model="customer.honeyPot"
					data-testid="web-traffic-test" />
			</div>

			<div class="field gdpr-field">
				<input
					id="gdpr"
					name="gdpr"
					type="checkbox"
					x-model="customer.gdpr"
					data-testid="gdpr-check"
					required />
				<label for="gdpr">
					Ich habe die
					<a href="https://authentische-momente.de/datenschutz" target="_blank" rel="noopener noreferrer">Datenschutzerklärung</a>
					zur Kenntnis genommen und bin damit einverstanden, dass meine Angaben zur Beantwortung meiner Anfrage verarbeitet werden.
				</label>
				<p class="error" data-error-for="customer.gdpr" x-show="error('customer.gdpr')" x-text="error('customer.gdpr')"></p>
			</div>

		</fieldset>

		<div class="submit-row">
			<button
				type="submit"
				class="submit-btn"
				data-testid="send-query-button"
				:disabled="isSubmitting"
				x-text="isSubmitting ? 'Wird gesendet…' : 'Absenden'"></button>
		</div>
	</form>
</section>

<?php
get_template_part( 'parts/footer-default', 'default', $footer_section );
?>
