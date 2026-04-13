<?php
require_once("inc/inc.Hoofd.php");
?>


<br>
<br>


   <section class="py-20 bg-gray-900" id="Contact">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">Contacteer ons</h2>
                <div class="w-24 h-1 bg-blue-500 mx-auto"></div>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto mt-4">
                    Een vraag? Een idee? Wij staan voor u klaar.
                </p>
            </div>  
            
            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <form class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Naam</label>
                            <input type="text" id="name" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                            <input type="email" id="email" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-300 mb-2">Onderwerp</label>
                            <select id="subject" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option>Informatieaanvraag</option>
                                <option>Technische ondersteuning</option>
                                <option>Samenwerking</option>
                                <option>Anders</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Bericht</label>
                            <textarea id="message" rows="4" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-full transition font-medium">
                            Verstuur bericht
                        </button>
                    </form>
                </div>
                
                <div>
                    <div class="bg-gray-800 p-8 rounded-xl">
                        <h3 class="text-2xl font-bold mb-6">Onze contactgegevens</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="text-blue-400 mr-4">
                                    <i data-feather="mail" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold mb-1">Email</h4>
                                    <a href="mailto:brayanetchinda54@gmail.com" class="text-gray-300 hover:text-blue-400 transition">brayanetchinda54@gmail.com</a>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="text-blue-400 mr-4">
                                    <i data-feather="map-pin" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold mb-1">Adres</h4>
                                    <p class="text-gray-300">platwijersweg 24b, 3520 Zonhoven, België</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="text-blue-400 mr-4">
                                    <i data-feather="clock" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold mb-1">Openingstijden</h4>
                                    <p class="text-gray-300">
                                        Maandag – Vrijdag : 09h00 – 18h00<br>
                                        Zaterdag : 10h00 – 14h00<br>
                                        Zondag : Gesloten
                                    </p>
                                </div>
                            </div>
                            
                            <div class="pt-4">
                                <h4 class="font-bold mb-4">Volg ons</h4>
                                <div class="flex space-x-4">
                                    <a href="https://www.instagram.com/brayane_chrome7/" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                                        <i data-feather="instagram" class="w-5 h-5"></i>
                                    </a>
                                    <a href="https://www.facebook.com/XXXBrayaneTchinda" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                                        <i data-feather="facebook" class="w-5 h-5"></i>
                                    </a>
                                    <a href="https://x.com/brayane_t" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                                        <i data-feather="twitter" class="w-5 h-5"></i>
                                    </a>
                                    <a href="https://www.youtube.com/@brayane.T" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                                        <i data-feather="youtube" class="w-5 h-5"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/in/brayane-tchinda-b2baa6236/" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                                        <i data-feather="linkedin" class="w-5 h-5"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



<?php
require_once("inc/inc.Voet.php");
?>