<div class="relative max-w-3xl mx-auto px-4 py-8">

    <!-- Timeline line -->
    <div class="absolute left-5 top-0 w-1 bg-gray-200 h-full"></div>
    <div class="absolute left-5 top-0 w-1 bg-green-500 h-0 transition-all duration-500" id="timeline-progress"></div>

    <!-- Header -->
    <div class="text-center mb-10 relative z-10">
        <span class="text-5xl mb-4 block">🚀</span>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
            Démarrage rapide
        </h1>
        <p class="text-gray-600">
            3 minutes pour être opérationnel
        </p>
    </div>

    <!-- Steps -->
    <div class="space-y-16 relative z-10">

        <!-- Step 1 -->
        <div class="flex items-start gap-6 step">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center font-bold step-dot">
                    ✓
                </div>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-800 mb-1">Installation</h3>
                <p class="text-green-600 text-sm font-medium">
                    <i class="fa-solid fa-check mr-1"></i> Déjà fait ! BrickPHP est installé et fonctionne.
                </p>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="flex items-start gap-6 step">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold step-dot">
                    1
                </div>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-800 mb-2">Configurer la base de données <span class="text-gray-400 font-normal text-sm">(optionnel)</span></h3>
                <p class="text-gray-600 text-sm mb-3">
                    Éditer <code class="bg-gray-100 px-2 py-1 rounded text-sm">src/Config/app.php</code>
                </p>
                <div class="bg-gray-900 rounded-xl p-4 text-sm overflow-x-auto">
                    <pre class="text-gray-300"><code><span class="text-purple-400">define</span>(<span class="text-green-400">'DB_HOST'</span>, <span class="text-yellow-400">'localhost'</span>);
<span class="text-purple-400">define</span>(<span class="text-green-400">'DB_NAME'</span>, <span class="text-yellow-400">'votre_bdd'</span>);
<span class="text-purple-400">define</span>(<span class="text-green-400">'DB_USER'</span>, <span class="text-yellow-400">'root'</span>);
<span class="text-purple-400">define</span>(<span class="text-green-400">'DB_PASS'</span>, <span class="text-yellow-400">''</span>);</code></pre>
                </div>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="flex items-start gap-6 step">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold step-dot">
                    2
                </div>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-800 mb-2">Créer une page</h3>
                <p class="text-gray-600 text-sm mb-3">
                    Ajouter une route dans <code class="bg-gray-100 px-2 py-1 rounded text-sm">routes/web.php</code>
                </p>
                <div class="bg-gray-900 rounded-xl p-4 text-sm overflow-x-auto">
                    <pre class="text-gray-300"><code><span class="text-gray-500">// Ajouter cette ligne :</span>
<span class="text-blue-400">$router</span>-><span class="text-yellow-400">get</span>(<span class="text-green-400">'/contact'</span>, [<span class="text-cyan-400">ContactController</span>::class, <span class="text-green-400">'index'</span>], <span class="text-green-400">'contact'</span>);</code></pre>
                </div>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="flex items-start gap-6 step">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold step-dot">
                    3
                </div>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-800 mb-2">Créer le Controller + Vue</h3>
                
                <p class="text-gray-600 text-sm mb-2">
                    <code class="bg-gray-100 px-2 py-1 rounded text-sm">src/Controller/ContactController.php</code>
                </p>
                <div class="bg-gray-900 rounded-xl p-4 text-sm overflow-x-auto mb-4">
                    <pre class="text-gray-300"><code><span class="text-purple-400">class</span> <span class="text-cyan-400">ContactController</span> <span class="text-purple-400">extends</span> <span class="text-cyan-400">BaseController</span> {
    <span class="text-purple-400">public function</span> <span class="text-yellow-400">index</span>(): <span class="text-cyan-400">void</span> {
        <span class="text-blue-400">$this</span>-><span class="text-yellow-400">render</span>(<span class="text-green-400">'contact'</span>, [<span class="text-green-400">'title'</span> => <span class="text-green-400">'Contact'</span>]);
    }
}</code></pre>
                </div>

                <p class="text-gray-600 text-sm mb-2">
                    <code class="bg-gray-100 px-2 py-1 rounded text-sm">src/View/contact.php</code>
                </p>
                <div class="bg-gray-900 rounded-xl p-4 text-sm overflow-x-auto">
                    <pre class="text-gray-300"><code><span class="text-pink-400">&lt;h1&gt;</span>Contact<span class="text-pink-400">&lt;/h1&gt;</span>
<span class="text-pink-400">&lt;p&gt;</span>Votre contenu ici !<span class="text-pink-400">&lt;/p&gt;</span></code></pre>
                </div>
            </div>
        </div>

        <!-- Step Done -->
        <div class="flex items-start gap-6 step">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center font-bold step-dot">
                    <i class="fa-solid fa-check"></i>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-green-800 mb-1">C'est tout !</h3>
                <p class="text-green-700 text-sm">
                    Accédez à <code class="bg-green-100 px-2 py-1 rounded text-sm">/contact</code> et votre page est en ligne 🎉
                </p>
            </div>
        </div>
    </div>

    <!-- Useful Links -->
    <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 shadow-lg border border-gray-100 mt-10 relative z-10">
        <h3 class="font-bold text-gray-800 mb-4">
            <i class="fa-solid fa-link text-blue-500 mr-2"></i> Liens utiles
        </h3>
        <div class="grid sm:grid-cols-2 gap-3">
            <a href="<?php route('components'); ?>" 
               class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                <i class="fa-solid fa-puzzle-piece text-purple-500"></i>
                <span class="text-gray-700">Voir les composants</span>
            </a>
            <a href="https://www.hyperui.dev/" target="_blank" 
               class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                <i class="fa-solid fa-palette text-cyan-500"></i>
                <span class="text-gray-700">HyperUI (composants Tailwind)</span>
                <i class="fa-solid fa-external-link text-gray-400 text-xs"></i>
            </a>
            <a href="https://tailwindcss.com/docs" target="_blank" 
               class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                <i class="fa-solid fa-wind text-cyan-500"></i>
                <span class="text-gray-700">Documentation Tailwind</span>
                <i class="fa-solid fa-external-link text-gray-400 text-xs"></i>
            </a>
            <a href="https://vuejs.org/guide/" target="_blank" 
               class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                <i class="fa-brands fa-vuejs text-green-500"></i>
                <span class="text-gray-700">Documentation Vue 3</span>
                <i class="fa-solid fa-external-link text-gray-400 text-xs"></i>
            </a>
        </div>
    </div>

    <!-- Back to home -->
    <div class="text-center mt-8 relative z-10">
        <a href="<?php route('home'); ?>" class="text-gray-500 hover:text-gray-700 text-sm">
            <i class="fa-solid fa-arrow-left mr-1"></i> Retour à l'accueil
        </a>
    </div>
</div>

<script>
// Animation de défilement de la timeline
const steps = document.querySelectorAll('.step');
const dots = document.querySelectorAll('.step-dot');
const line = document.getElementById('timeline-progress');

function updateTimeline() {
    let scrollTop = window.scrollY + window.innerHeight/2;
    steps.forEach((step, i) => {
        let stepTop = step.offsetTop;
        if(scrollTop > stepTop) {
            dots[i].classList.remove('bg-gray-400');
            dots[i].classList.add('bg-green-500');
            line.style.height = `${stepTop + 40}px`;
        }
    });
}

window.addEventListener('scroll', updateTimeline);
window.addEventListener('load', updateTimeline);
</script>
