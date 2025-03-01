<section class="relative bg-gray-900 overflow-hidden">
    <!-- Background image container with overlay -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/back.png') }}" alt="Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gray-900/75"></div>
    </div>

    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                    Finance with security and flexibility
                </h1>
                <p class="mt-6 text-lg text-gray-300">
                    Experience the future of digital payments with CredXPay's secure and innovative platform.
                </p>
                <div class="mt-8">
                    <a href="{{ route('register') }}" class="inline-block bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded-lg text-md font-medium transition-colors duration-200">
                        Open Account
                    </a>
                </div>
            </div>
            <div class="relative select-none">
                <div id="card-container" class="cursor-pointer bg-none hover:bg-none">
                    <div class="card-overlay"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Initialize Three.js scene
const container = document.getElementById('card-container');
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75, container.clientWidth / container.clientHeight, 0.1, 1000);
const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });

renderer.setSize(container.clientWidth, container.clientHeight);
container.appendChild(renderer.domElement);

// Create credit card geometry with increased thickness
const cardGeometry = new THREE.BoxGeometry(8, 5, 0.2);
const textureLoader = new THREE.TextureLoader();

// Load card textures
const frontTexture = textureLoader.load('{{ asset("images/card-front.png") }}', (texture) => {
    texture.minFilter = THREE.LinearFilter;
    texture.magFilter = THREE.LinearFilter;
});

const backTexture = textureLoader.load('{{ asset("images/card-back.png") }}', (texture) => {
    texture.minFilter = THREE.LinearFilter;
    texture.magFilter = THREE.LinearFilter;
});

// Create materials for the card without filters
const materials = [
    new THREE.MeshPhongMaterial({ color: 0x1a1a1a }), // Right side
    new THREE.MeshPhongMaterial({ color: 0x1a1a1a }), // Left side
    new THREE.MeshPhongMaterial({ color: 0x1a1a1a }), // Top side
    new THREE.MeshPhongMaterial({ color: 0x1a1a1a }), // Bottom side
    new THREE.MeshPhongMaterial({
        map: frontTexture,
        metalness: 0,
        roughness: 0
    }), // Front side
    new THREE.MeshPhongMaterial({
        map: backTexture,
        metalness: 0,
        roughness: 0
    }) // Back side
];

const card = new THREE.Mesh(cardGeometry, materials);
scene.add(card);

// Add lights
const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
scene.add(ambientLight);

const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
directionalLight.position.set(5, 5, 5);
scene.add(directionalLight);

const pointLight = new THREE.PointLight(0x00ffff, 1, 100);
pointLight.position.set(5, 5, 5);
scene.add(pointLight);

// Set camera position to be directly in front of the card and align rotation
camera.position.set(0, 0, 8);
card.rotation.set(0, Math.PI, 0);

// Initial rotation animation on load
gsap.to(card.rotation, {
    y: Math.PI * 3,
    duration: 4, // Slower rotation duration on load
    ease: "power2.inOut",
    onComplete: () => {
        card.rotation.y = Math.PI; // Set back to front view after rotation
    }
});

// Add hover effect
container.addEventListener('mousemove', (event) => {
    const rect = container.getBoundingClientRect();
    const x = ((event.clientX - rect.left) / container.clientWidth) * 2 - 1;
    const y = -((event.clientY - rect.top) / container.clientHeight) * 2 + 1;

    gsap.to(card.rotation, {
        x: y * 0.5, // Reduced sensitivity for y-axis
        y: Math.PI + x * 0.5, // Reduced sensitivity for x-axis
        duration: 0.5
    });
});

// Handle mouse leave to reset position
container.addEventListener('mouseleave', () => {
    gsap.to(card.rotation, {
        x: 0,
        y: Math.PI,
        duration: 0.5
    });
});

// Update scroll animation to avoid conflicts
gsap.to(card.rotation, {
    y: Math.PI * 5,
    scrollTrigger: {
        trigger: container,
        start: "top center",
        end: "bottom center",
        scrub: 1
    }
});

// Animation loop
function animate() {
    requestAnimationFrame(animate);
    renderer.render(scene, camera);
}

animate();

// Handle window resize
window.addEventListener('resize', () => {
    camera.aspect = container.clientWidth / container.clientHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(container.clientWidth, container.clientHeight);
});
</script>