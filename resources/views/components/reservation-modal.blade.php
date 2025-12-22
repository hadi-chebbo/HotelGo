@props(['roomType'])

<div x-data="reservationModal({{ $roomType->id }}, {{ Auth::check() ? Auth::user()->loyalty_points : 0 }})">
    <!-- Book Now Button -->
    <button @click="openModal()"
        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all">
        Book Now
    </button>

    <!-- Modal Overlay -->
    <template x-teleport="body">
        <div x-show="open" 
             x-cloak
             @keydown.escape.window="closeModal()"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[9999] overflow-y-auto"
             style="position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important; bottom: 0 !important;">
            
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="closeModal()"></div>
            
            <!-- Modal Container -->
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div @click.stop
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="relative bg-white rounded-xl w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl">
                    
                    <div class="p-5 space-y-3">
                        <!-- Close Button -->
                        <button @click="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 z-10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        <!-- Step 1: Date Selection with Calendar -->
                        <div x-show="step === 1" x-transition>
                            <h2 class="text-xl font-bold text-gray-800 mb-4">Select Your Dates</h2>
                            
                            <!-- Calendar -->
                            <div class="bg-gray-50 rounded-lg p-3 mb-3">
                                <!-- Month Navigation -->
                                <div class="flex items-center justify-between mb-3">
                                    <button @click="previousMonth()" class="p-1.5 hover:bg-gray-200 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>
                                    <div class="text-sm font-semibold" x-text="currentMonthYear"></div>
                                    <button @click="nextMonth()" class="p-1.5 hover:bg-gray-200 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Day Headers -->
                                <div class="grid grid-cols-7 gap-0.5 mb-1">
                                    <div class="text-center text-[10px] font-semibold text-gray-600 py-1">S</div>
                                    <div class="text-center text-[10px] font-semibold text-gray-600 py-1">M</div>
                                    <div class="text-center text-[10px] font-semibold text-gray-600 py-1">T</div>
                                    <div class="text-center text-[10px] font-semibold text-gray-600 py-1">W</div>
                                    <div class="text-center text-[10px] font-semibold text-gray-600 py-1">T</div>
                                    <div class="text-center text-[10px] font-semibold text-gray-600 py-1">F</div>
                                    <div class="text-center text-[10px] font-semibold text-gray-600 py-1">S</div>
                                </div>

                                <!-- Calendar Days -->
                                <div class="grid grid-cols-7 gap-0.5">
                                    <template x-for="day in calendarDays" :key="day.date">
                                        <button
                                            @click="selectDate(day.date)"
                                            :disabled="day.isUnavailable || day.isPast"
                                            :class="{
                                                'opacity-30 cursor-not-allowed': day.isUnavailable || day.isPast,
                                                'bg-blue-600 text-white hover:bg-blue-700': day.isSelected && !day.isUnavailable,
                                                'bg-blue-100 text-blue-600': day.isInRange && !day.isSelected,
                                                'hover:bg-gray-200': !day.isSelected && !day.isUnavailable && !day.isPast && !day.isOtherMonth,
                                                'text-gray-400': day.isOtherMonth,
                                                'font-semibold': day.isToday
                                            }"
                                            class="h-8 w-8 flex items-center justify-center text-xs rounded-md transition-all"
                                            x-text="day.day"
                                        ></button>
                                    </template>
                                </div>
                            </div>

                            <!-- Selected Dates Display -->
                            <div class="flex gap-2 mb-3">
                                <div class="flex-1">
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Check-in</label>
                                    <div class="border border-gray-300 rounded-lg p-2 bg-white text-xs" x-text="check_in_date ? formatDateDisplay(check_in_date) : 'Select date'"></div>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Check-out</label>
                                    <div class="border border-gray-300 rounded-lg p-2 bg-white text-xs" x-text="check_out_date ? formatDateDisplay(check_out_date) : 'Select date'"></div>
                                </div>
                            </div>

                            <input type="text" 
                                   x-model="promo_code" 
                                   placeholder="Promo Code (optional)"
                                   class="border border-gray-300 rounded-lg p-2.5 w-full text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent mb-2">
                            
                            <label x-show="userLoyaltyPoints >= 500" class="flex items-center gap-2 mb-3 cursor-pointer">
                                <input type="checkbox" x-model="loyalty" class="w-4 h-4 text-blue-600 rounded">
                                <span class="text-xs font-medium text-gray-700">
                                    Use Loyalty Points (<span x-text="userLoyaltyPoints"></span> points = 20% off)
                                </span>
                            </label>
                            
                            <button @click="previewReservation()"
                                    :disabled="loading || !check_in_date || !check_out_date"
                                    class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-5 py-2.5 rounded-lg font-semibold text-sm w-full hover:shadow-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-show="!loading">Preview Reservation</span>
                                <span x-show="loading">Loading...</span>
                            </button>
                        </div>

                        <!-- Step 2: Preview -->
                        <div x-show="step === 2" x-transition>
                            <h2 class="text-xl font-bold text-gray-800 mb-3">Reservation Summary</h2>
                            
                            <div class="bg-gray-50 rounded-lg p-3 space-y-2 mb-3">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Number of Nights:</span>
                                    <span class="font-bold" x-text="preview.days ?? 0"></span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Total Price:</span>
                                    <span class="font-bold text-emerald-600">$<span x-text="preview.total_price ?? 0"></span></span>
                                </div>
                                <div class="flex justify-between items-center border-t pt-2">
                                    <span class="text-gray-600 text-sm">Deposit (25%):</span>
                                    <span class="font-bold text-lg text-blue-600">$<span x-text="preview.deposit ?? 0"></span></span>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <button @click="step = 1" 
                                        class="flex-1 bg-gray-200 text-gray-700 px-4 py-2.5 text-sm rounded-lg font-semibold hover:bg-gray-300 transition-all">
                                    Back
                                </button>
                                <button @click="step = 3" 
                                        class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-4 py-2.5 text-sm rounded-lg font-semibold hover:shadow-lg transition-all">
                                    Continue to Payment
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Payment -->
                        <div x-show="step === 3" x-transition>
                            <h2 class="text-xl font-bold text-gray-800 mb-3">Payment Details</h2>
                            
                            <input type="text" 
                                   x-model="card_number" 
                                   placeholder="Card Number" 
                                   maxlength="19"
                                   class="border border-gray-300 rounded-lg p-2.5 text-sm w-full mb-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            
                            <input type="text" 
                                   x-model="card_holder" 
                                   placeholder="Card Holder Name" 
                                   class="border border-gray-300 rounded-lg p-2.5 text-sm w-full mb-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            
                            <div class="flex gap-2 mb-2">
                                <input type="text" 
                                       x-model="expiry_date" 
                                       placeholder="MM/YY" 
                                       maxlength="5"
                                       class="border border-gray-300 rounded-lg p-2.5 text-sm w-1/2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <input type="text" 
                                       x-model="cvv" 
                                       placeholder="CVV" 
                                       maxlength="3"
                                       class="border border-gray-300 rounded-lg p-2.5 text-sm w-1/2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            
                            <select x-model="payment_method" 
                                    class="border border-gray-300 rounded-lg p-2.5 text-sm w-full mb-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="card">Credit/Debit Card</option>
                                <option value="cash">Cash on Arrival</option>
                            </select>
                            
                            <div class="flex gap-2">
                                <button @click="step = 2" 
                                        class="flex-1 bg-gray-200 text-gray-700 px-4 py-2.5 text-sm rounded-lg font-semibold hover:bg-gray-300 transition-all">
                                    Back
                                </button>
                                <button @click="storeReservation()" 
                                        :disabled="loading"
                                        class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2.5 text-sm rounded-lg font-semibold hover:shadow-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span x-show="!loading">Confirm Reservation</span>
                                    <span x-show="loading">Processing...</span>
                                </button>
                            </div>
                        </div>

                        <!-- Errors and Success Messages -->
                        <div x-show="error" 
                             x-transition
                             class="mt-3 p-2.5 bg-red-50 border border-red-200 rounded-lg text-red-700 text-xs" 
                             x-text="error">
                        </div>
                        
                        <div x-show="success" 
                             x-transition
                             class="mt-3 p-2.5 bg-green-50 border border-green-200 rounded-lg text-green-700 text-xs font-semibold" 
                             x-text="success">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
function reservationModal(roomTypeId, loyaltyPoints = 0) {
    return {
        open: false,
        step: 1,
        loading: false,
        check_in_date: '',
        check_out_date: '',
        promo_code: '',
        loyalty: false,
        card_number: '',
        card_holder: '',
        expiry_date: '',
        cvv: '',
        payment_method: 'card',
        preview: {},
        error: '',
        success: '',
        unavailableDates: [],
        currentMonth: new Date().getMonth(),
        currentYear: new Date().getFullYear(),
        selectingCheckOut: false,
        userLoyaltyPoints: loyaltyPoints,

        get currentMonthYear() {
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 
                          'July', 'August', 'September', 'October', 'November', 'December'];
            return `${months[this.currentMonth]} ${this.currentYear}`;
        },

        get calendarDays() {
            const firstDay = new Date(this.currentYear, this.currentMonth, 1);
            const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
            const prevLastDay = new Date(this.currentYear, this.currentMonth, 0);
            
            const days = [];
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            // Previous month days
            const firstDayOfWeek = firstDay.getDay();
            for (let i = firstDayOfWeek - 1; i >= 0; i--) {
                const date = new Date(this.currentYear, this.currentMonth, -i);
                days.push(this.createDayObject(date, true));
            }

            // Current month days
            for (let i = 1; i <= lastDay.getDate(); i++) {
                const date = new Date(this.currentYear, this.currentMonth, i);
                days.push(this.createDayObject(date, false));
            }

            // Next month days
            const remainingDays = 42 - days.length; // 6 rows x 7 days
            for (let i = 1; i <= remainingDays; i++) {
                const date = new Date(this.currentYear, this.currentMonth + 1, i);
                days.push(this.createDayObject(date, true));
            }

            return days;
        },

        createDayObject(date, isOtherMonth) {
            const dateStr = date.toISOString().split('T')[0];
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            const checkIn = this.check_in_date ? new Date(this.check_in_date) : null;
            const checkOut = this.check_out_date ? new Date(this.check_out_date) : null;

            return {
                date: dateStr,
                day: date.getDate(),
                isOtherMonth: isOtherMonth,
                isToday: date.toDateString() === today.toDateString(),
                isPast: date < today,
                isUnavailable: this.unavailableDates.includes(dateStr),
                isSelected: dateStr === this.check_in_date || dateStr === this.check_out_date,
                isInRange: checkIn && checkOut && date > checkIn && date < checkOut
            };
        },

        previousMonth() {
            if (this.currentMonth === 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else {
                this.currentMonth--;
            }
        },

        nextMonth() {
            if (this.currentMonth === 11) {
                this.currentMonth = 0;
                this.currentYear++;
            } else {
                this.currentMonth++;
            }
        },

        selectDate(dateStr) {
            if (!this.check_in_date || (this.check_in_date && this.check_out_date)) {
                // Select check-in
                this.check_in_date = dateStr;
                this.check_out_date = '';
                this.selectingCheckOut = true;
            } else {
                // Select check-out
                const checkIn = new Date(this.check_in_date);
                const checkOut = new Date(dateStr);
                
                if (checkOut > checkIn) {
                    this.check_out_date = dateStr;
                    this.selectingCheckOut = false;
                    this.checkDateRangeConflict();
                } else {
                    // If selected date is before check-in, reset and start over
                    this.check_in_date = dateStr;
                    this.check_out_date = '';
                }
            }
        },

        formatDateDisplay(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-US', { 
                weekday: 'short', 
                month: 'short', 
                day: 'numeric',
                year: 'numeric'
            });
        },

        openModal() {
            this.open = true;
            this.step = 1;
            this.error = '';
            this.success = '';
            this.loadUnavailableDates();
            document.body.style.overflow = 'hidden';
        },

        closeModal() {
            this.open = false;
            document.body.style.overflow = '';
        },

        getCsrfToken() {
            const token = document.querySelector('meta[name="csrf-token"]');
            if (!token) {
                console.error('CSRF token not found!');
                return '';
            }
            return token.content;
        },

        loadUnavailableDates() {
            fetch(`/rooms/${roomTypeId}/unavailable-dates`)
                .then(res => res.json())
                .then(data => {
                    this.unavailableDates = data.unavailable_dates || [];
                })
                .catch(err => {
                    console.error('Failed to load unavailable dates:', err);
                });
        },

        checkDateRangeConflict() {
            if (!this.check_in_date || !this.check_out_date) return false;

            const checkIn = new Date(this.check_in_date);
            const checkOut = new Date(this.check_out_date);
            
            const hasConflict = this.unavailableDates.some(unavailableDate => {
                const unavailable = new Date(unavailableDate);
                return unavailable >= checkIn && unavailable < checkOut;
            });

            if (hasConflict) {
                this.error = 'Your selected dates conflict with existing reservations. Please choose different dates.';
                return true;
            }
            
            this.error = '';
            return false;
        },

        previewReservation() {
            if (this.checkDateRangeConflict()) return;

            if (!this.check_in_date || !this.check_out_date) {
                this.error = 'Please select check-in and check-out dates.';
                return;
            }

            this.loading = true;
            this.error = '';

            fetch(`/rooms/${roomTypeId}/preview`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken()
                },
                body: JSON.stringify({
                    check_in_date: this.check_in_date,
                    check_out_date: this.check_out_date,
                    promo_code: this.promo_code,
                    loyalty: this.loyalty
                })
            })
            .then(res => res.json())
            .then(data => {
                this.loading = false;
                
                if(data.error) {
                    this.error = typeof data.error === 'object' ? Object.values(data.error).flat().join(', ') : data.error;
                    return;
                } 
                
                if (data.errors) {
                    this.error = Object.values(data.errors).flat().join(', ');
                    return;
                }
                
                if ('days' in data && 'total_price' in data && 'deposit' in data) {
                    this.preview = {
                        days: data.days,
                        total_price: data.total_price,
                        deposit: data.deposit
                    };
                    this.step = 2;
                    this.error = '';
                }
            })
            .catch(err => {
                this.loading = false;
                this.error = 'Something went wrong. Please try again.';
                console.error('Preview error:', err);
            });
        },

        storeReservation() {
            this.loading = true;
            this.error = '';

            fetch(`/rooms/${roomTypeId}/create`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken()
                },
                body: JSON.stringify({
                    check_in_date: this.check_in_date,
                    check_out_date: this.check_out_date,
                    promo_code: this.promo_code,
                    loyalty: this.loyalty,
                    card_number: this.card_number,
                    card_holder: this.card_holder,
                    expiry_date: this.expiry_date,
                    cvv: this.cvv,
                    payment_method: this.payment_method
                })
            })
            .then(res => res.json())
            .then(data => {
                this.loading = false;
                if(data.error) {
                    this.error = typeof data.error === 'object' ? Object.values(data.error).flat().join(', ') : data.error;
                } else if (data.errors) {
                    this.error = Object.values(data.errors).flat().join(', ');
                } else if (data.success) {
                    this.success = '✓ Reservation confirmed successfully!';
                    setTimeout(() => {
                        this.closeModal();
                        this.resetForm();
                        window.location.reload();
                    }, 2000);
                }
            })
            .catch(err => {
                this.loading = false;
                this.error = 'Something went wrong. Please try again.';
                console.error('Reservation error:', err);
            });
        },

        resetForm() {
            this.step = 1;
            this.preview = {};
            this.check_in_date = '';
            this.check_out_date = '';
            this.promo_code = '';
            this.loyalty = false;
            this.card_number = '';
            this.card_holder = '';
            this.expiry_date = '';
            this.cvv = '';
        }
    }
}
</script>