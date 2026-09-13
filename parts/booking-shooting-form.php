<?php

/**
 * Booking Shooting Form Part
 *
 * @package a_m_theme
 */

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

		<!-- Participants -->
		<fieldset data-testid="booking-step-participants">
			<legend>Wer wird da sein?</legend>
			<div class="field-row">
				<div class="field">
					<label for="adults">Erwachsene</label>
					<input
						id="adults"
						name="adults"
						type="text"
						inputmode="numeric"
						placeholder="min. 1"
						x-model="booking.participants.adults"
						data-testid="adults-test-id"
						required />
					<p
						class="error"
						data-error-for="booking.participants.adults"
						x-show="error('booking.participants.adults')"
						x-text="error('booking.participants.adults')"></p>
				</div>
				<div class="field">
					<label for="childrens">Kinder ab zwei Jahren</label>
					<input
						id="childrens"
						name="childrens"
						type="text"
						inputmode="numeric"
						placeholder="0"
						x-model="booking.participants.childrens"
						data-testid="children-test-id" />
					<p
						class="error"
						data-error-for="booking.participants.childrens"
						x-show="error('booking.participants.childrens')"
						x-text="error('booking.participants.childrens')"></p>
				</div>
				<div class="field">
					<label for="toddlers">Kinder bis zwei Jahren</label>
					<input
						id="toddlers"
						name="toddlers"
						type="text"
						inputmode="numeric"
						placeholder="0"
						x-model="booking.participants.toddlers"
						data-testid="toddlers-test-id" />
					<p
						class="error"
						data-error-for="booking.participants.toddlers"
						x-show="error('booking.participants.toddlers')"
						x-text="error('booking.participants.toddlers')"></p>
				</div>
				<div class="field">
					<label for="animals">Haustiere</label>
					<input
						id="animals"
						name="animals"
						type="text"
						inputmode="numeric"
						placeholder="0"
						x-model="booking.participants.animals"
						data-testid="animals-test-id" />
					<p
						class="error"
						data-error-for="booking.participants.animals"
						x-show="error('booking.participants.animals')"
						x-text="error('booking.participants.animals')"></p>
				</div>
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
						data-testid="first-name"
						required />
					<p class="error" data-error-for="customer.firstName" x-show="error('customer.firstName')" x-text="error('customer.firstName')"></p>
				</div>
				<div class="field">
					<label for="lastName">Nachname&nbsp;*</label>
					<input
						id="lastName"
						name="lastName"
						type="text"
						autocomplete="family-name"
						x-model="customer.lastName"
						data-testid="last-name"
						required />
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
					<label for="mobilePhone">Handy Nummer</label>
					<input
						id="mobilePhone"
						name="mobilePhone"
						type="tel"
						autocomplete="tel"
						placeholder="optional"
						x-model="customer.mobilePhone"
						data-testid="mobile-phone" />
					<p class="error" data-error-for="customer.mobilePhone" x-show="error('customer.mobilePhone')" x-text="error('customer.mobilePhone')"></p>
				</div>
				<div class="field">
					<label for="street">Straße</label>
					<input
						id="street"
						name="street"
						type="text"
						autocomplete="address-line1"
						placeholder="optional"
						x-model="customer.street"
						data-testid="street-name" />
					<p class="error" data-error-for="customer.street" x-show="error('customer.street')" x-text="error('customer.street')"></p>
				</div>
				<div class="field">
					<label for="houseNumber">Hausnummer</label>
					<input
						id="houseNumber"
						name="houseNumber"
						type="text"
						autocomplete="address-line2"
						placeholder="optional"
						x-model="customer.houseNumber"
						data-testid="house-number" />
					<p class="error" data-error-for="customer.houseNumber" x-show="error('customer.houseNumber')" x-text="error('customer.houseNumber')"></p>
				</div>
				<div class="field">
					<label for="zipCode">PLZ</label>
					<input
						id="zipCode"
						name="zipCode"
						type="text"
						inputmode="numeric"
						autocomplete="postal-code"
						placeholder="optional"
						x-model="customer.zipCode"
						data-testid="zip-code" />
					<p class="error" data-error-for="customer.zipCode" x-show="error('customer.zipCode')" x-text="error('customer.zipCode')"></p>
				</div>
				<div class="field">
					<label for="city">Stadt</label>
					<input
						id="city"
						name="city"
						type="text"
						autocomplete="address-level2"
						placeholder="optional"
						x-model="customer.city"
						data-testid="city-name" />
					<p class="error" data-error-for="customer.city" x-show="error('customer.city')" x-text="error('customer.city')"></p>
				</div>
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
