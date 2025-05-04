<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mobilization Calculator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function updateTotals() {
            let rows = document.querySelectorAll('#laborRows tr');
            let grandTotal = 0;

            const normalDays = parseFloat(document.getElementById('days').value) || 0;
            const holidayRate = parseFloat(document.getElementById('holidayRate').value) / 100 || 0;
            const sundayRate = parseFloat(document.getElementById('sundayRate').value) / 100 || 0;

            // Mark-up fields
            const laborMarkup = parseFloat(document.getElementById('laborMarkup').value) / 100 || 0;
            const tollMarkup = parseFloat(document.getElementById('tollMarkup').value) / 100 || 0;
            const gasMarkup = parseFloat(document.getElementById('gasMarkup').value) / 100 || 0;

            rows.forEach(row => {
                const position = row.querySelector('.position').innerText.toLowerCase();
                const rate = parseFloat(row.querySelector('.rate').value) || 0;
                const qty = parseFloat(row.querySelector('.qty').value) || 0;
                const holidayDays = parseFloat(row.querySelector('.holiday-days').value) || 0;
                const sundayDays = parseFloat(row.querySelector('.sunday-days').value) || 0;

                let effectiveDays = normalDays;
                if (position !== "on-call") {
                    effectiveDays += holidayDays * holidayRate;
                    effectiveDays += sundayDays * sundayRate;
                } else {
                    effectiveDays += holidayDays + sundayDays;
                }

                let total = rate * qty * effectiveDays;
                total += total * laborMarkup; // Apply labor markup
                row.querySelector('.total').innerText = total.toFixed(2);
                grandTotal += total;
            });

            document.getElementById('laborTotal').innerText = grandTotal.toFixed(2);

            const mealCost = parseFloat(document.getElementById('mealCost').value) || 0;
            const crewCount = parseFloat(document.getElementById('crewCount').value) || 0;
            const mealTotal = mealCost * crewCount * normalDays;
            document.getElementById('mealTotal').innerText = mealTotal.toFixed(2);

            const subtotal = grandTotal + mealTotal;

            // Additional cost calculations
            const tollFee = parseFloat(document.getElementById('tollFee').value) || 0;
            const numTrips = parseFloat(document.getElementById('numTrips').value) || 0;
            const numHauling = parseFloat(document.getElementById('numHauling').value) || 0;
            let totalTollFee = tollFee * numTrips * numHauling;
            totalTollFee += totalTollFee * tollMarkup; // Apply toll fee markup
            document.getElementById('totalTollFee').innerText = totalTollFee.toFixed(2);

            const numTrucks = parseFloat(document.getElementById('numTrucks').value) || 0;
            const dieselPerKm = parseFloat(document.getElementById('dieselPerKm').value) || 0;
            const distance = parseFloat(document.getElementById('distance').value) || 0;
            let gasAllowancePerTruck = dieselPerKm * distance * numHauling * numTrips * numTrucks;
            gasAllowancePerTruck += gasAllowancePerTruck * gasMarkup; // Apply gas markup
            document.getElementById('gasTotal').innerText = gasAllowancePerTruck.toFixed(2);

            // Sub con wing van 
            const wingvanCount = parseFloat(document.getElementById('wingvanCount').value) || 0;
            const wingvanCost = parseFloat(document.getElementById('wingvanCost').value) || 0;
           
            let totalWingvan = wingvanCount * wingvanCost;
            // sub con crane
            const craneCount = parseFloat(document.getElementById('craneCount').value) || 0;
            const craneCost = parseFloat(document.getElementById('craneCost').value) || 0;
           
            let totalCrane = craneCount * craneCost;
            // subcon manpower
            const manpowerCount = parseFloat(document.getElementById('manpowerCount').value) || 0;
            const manpowerCost = parseFloat(document.getElementById('manpowerCost').value) || 0;
           
            let totalManpower = manpowerCount * manpowerCost;
            // subcon equipmenmt
        
            const equipmentCost = parseFloat(document.getElementById('equipmentCost').value) || 0;
           
         
            const totalSubcon = totalWingvan + totalCrane + totalManpower + equipmentCost;
            document.getElementById('totalSubconFee').innerText = totalSubcon.toFixed(2);
            const tollTotalPerTruck = totalTollFee; // same value reused here
            document.getElementById('tollTotal').innerText = tollTotalPerTruck.toFixed(2);

            const finalGrandTotal = subtotal + totalTollFee + gasAllowancePerTruck + totalSubcon;
            document.getElementById('grandTotal').innerText = finalGrandTotal.toFixed(2);
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-xl shadow-xl">
        <h1 class="text-2xl font-bold mb-6 text-center text-blue-700">Mobilization Labor Cost Calculator</h1>

        <form oninput="updateTotals()">
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">Number of Days</label>
                    <input id="days" type="number" value="1" class="w-full border px-3 py-2" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Holiday Rate %</label>
                    <input id="holidayRate" type="number" value="50" class="w-full border px-3 py-2" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Sunday Rate %</label>
                    <input id="sundayRate" type="number" value="12.5" class="w-full border px-3 py-2" />
                </div>
            </div>

            <!-- Mark-up Fields -->
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">Labor Markup %</label>
                    <input id="laborMarkup" type="number" value="0" class="w-full border px-3 py-2" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Toll Markup %</label>
                    <input id="tollMarkup" type="number" value="0" class="w-full border px-3 py-2" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Gas Markup %</label>
                    <input id="gasMarkup" type="number" value="0" class="w-full border px-3 py-2" />
                </div>
            </div>

            <!-- Additional Inputs -->
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">Toll Fee</label>
                    <input id="tollFee" type="number" value="0" class="w-full border px-3 py-2" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Number of Trips (Ingress/Egress)</label>
                    <input id="numTrips" type="number" value="1" class="w-full border px-3 py-2" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Number of Hauling</label>
                    <input id="numHauling" type="number" value="1" class="w-full border px-3 py-2" />
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">Number of Trucks</label>
                    <input id="numTrucks" type="number" value="1" class="w-full border px-3 py-2" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Diesel per Km</label>
                    <input id="dieselPerKm" type="number" value="0" class="w-full border px-3 py-2" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Distance from Warehouse to Venue (km)</label>
                    <input id="distance" type="number" value="0" class="w-full border px-3 py-2" />
                </div>
            </div>

            <div class="overflow-auto">
                <table class="w-full text-sm mb-6 border">
                    <thead>
                        <tr class="bg-blue-100 text-blue-900 text-center">
                            <th class="p-3 border">Position</th>
                            <th class="p-3 border">Rate / 8hrs</th>
                            <th class="p-3 border">Quantity</th>
                            <th class="p-3 border">Holiday Days</th>
                            <th class="p-3 border">Sunday Days</th>
                            <th class="p-3 border">Total</th>
                        </tr>
                    </thead>
                    <tbody id="laborRows">
                        <tr class="text-center border">
                            <td class="p-2 border position">Supervisor</td>
                            <td class="p-2 border"><input type="number" class="rate w-full border px-2 py-1"
                                    value="1000" /></td>
                            <td class="p-2 border"><input type="number" class="qty w-full border px-2 py-1" value="1" />
                            </td>
                            <td class="p-2 border"><input type="number" class="holiday-days w-full border px-2 py-1"
                                    value="0" /></td>
                            <td class="p-2 border"><input type="number" class="sunday-days w-full border px-2 py-1"
                                    value="0" /></td>
                            <td class="p-2 border total">0.00</td>
                        </tr>
                        <tr class="text-center border">
                            <td class="p-2 border position">Electrician</td>
                            <td class="p-2 border"><input type="number" class="rate w-full border px-2 py-1"
                                    value="710" /></td>
                            <td class="p-2 border"><input type="number" class="qty w-full border px-2 py-1" value="1" />
                            </td>
                            <td class="p-2 border"><input type="number" class="holiday-days w-full border px-2 py-1"
                                    value="0" /></td>
                            <td class="p-2 border"><input type="number" class="sunday-days w-full border px-2 py-1"
                                    value="0" /></td>
                            <td class="p-2 border total">0.00</td>
                        </tr>
                        <!-- Add more rows here as needed -->
                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-3 gap-6 mb-4">
                <div>
                    <label class="block font-medium mb-1">Cost per Meal</label>
                    <input id="mealCost" type="number" value="0" class="w-full border px-3 py-2" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Number of Crew</label>
                    <input id="crewCount" type="number" value="0" class="w-full border px-3 py-2" />
                </div>

            </div>
            <h3 class="text-xl p-4 font-bold">Subcon</h3>
            <h2>Wingvan</h2>
            <div class="grid grid-cols-3 gap-6 mb-4">
                <div>
                    <label class="block font-medium mb-1">Quantity</label>
                    <input id="wingvanCount" type="number" value="0" class="w-full border px-3 py-2" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Cost</label>
                    <input id="wingvanCost" type="number" value="0" class="w-full border px-3 py-2" />
                </div>
            </div>
            <h2>Mobile Crane</h2>
            <div class="grid grid-cols-3 gap-6 mb-4">
                <div>
                    <label class="block font-medium mb-1">Quantity</label>
                    <input id="craneCount" type="number" value="0" class="w-full border px-3 py-2" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Cost</label>
                    <input id="craneCost" type="number" value="0" class="w-full border px-3 py-2" />
                </div>
            </div>
            <h2>Manpower</h2>
            <div class="grid grid-cols-3 gap-6 mb-4">
                <div>
                    <label class="block font-medium mb-1">Quantity</label>
                    <input id="manpowerCount" type="number" value="0" class="w-full border px-3 py-2" />
                </div>
                <div>
                    <label class="block font-medium mb-1">Cost</label>
                    <input id="manpowerCost" type="number" value="0" class="w-full border px-3 py-2" />
                </div>
            </div>
            <h2>Equipment</h2>
            <div class="grid grid-cols-3 gap-6 mb-4">
               
                <div>
                    <label class="block font-medium mb-1">Cost</label>
                    <input id="equipmentCost" type="number" value="0" class="w-full border px-3 py-2" />
                </div>
            </div>
            <div class="grid grid-cols-3 gap-6 mb-4 ">

                <div class="flex flex-col justify-center">
                    <div class="bg-blue-50 p-4 rounded-lg shadow text-blue-900">
                        <p><strong>Labor Total:</strong> ₱<span id="laborTotal">0.00</span></p>
                        <p><strong>Meal Total:</strong> ₱<span id="mealTotal">0.00</span></p>
                        <p><strong>Total Toll Fee:</strong> ₱<span id="totalTollFee">0.00</span></p>
                        <p><strong>Total Gas Allowance per Truck:</strong> ₱<span id="gasTotal">0.00</span></p>
                        <p><strong>Total Toll Fee Expenses per Truck:</strong> ₱<span id="tollTotal">0.00</span></p>
                        <p><strong>Total Subcon Fee:</strong> ₱<span id="totalSubconFee">0.00</span></p>
                        <p class="text-lg font-bold mt-2">Grand Total: ₱<span id="grandTotal">0.00</span></p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>