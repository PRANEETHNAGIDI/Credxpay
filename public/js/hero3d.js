import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

class Hero3D {
    constructor() {
        this.container = document.getElementById('hero-3d');
        this.scene = new THREE.Scene();
        this.camera = new THREE.PerspectiveCamera(75, this.container.clientWidth / this.container.clientHeight, 0.1, 1000);
        this.renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        
        this.init();
        this.setupLights();
        this.createCard();
        this.animate();
        this.setupScrollAnimation();
    }

    init() {
        this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
        this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        this.container.appendChild(this.renderer.domElement);

        this.camera.position.z = 5;
        
        window.addEventListener('resize', () => this.onWindowResize());
    }

    setupLights() {
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
        this.scene.add(ambientLight);

        const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
        directionalLight.position.set(2, 2, 5);
        this.scene.add(directionalLight);
    }

    createCard() {
        // Create a simple credit card geometry
        const geometry = new THREE.BoxGeometry(3, 2, 0.1);
        const material = new THREE.MeshPhongMaterial({
            color: 0x00b894,
            specular: 0x4834d4,
            shininess: 100,
        });
        
        this.card = new THREE.Mesh(geometry, material);
        this.scene.add(this.card);

        // Add chip detail
        const chipGeometry = new THREE.BoxGeometry(0.5, 0.5, 0.12);
        const chipMaterial = new THREE.MeshPhongMaterial({ color: 0xffd700 });
        const chip = new THREE.Mesh(chipGeometry, chipMaterial);
        chip.position.set(-0.8, 0.3, 0.06);
        this.card.add(chip);
    }

    setupScrollAnimation() {
        gsap.to(this.card.rotation, {
            x: Math.PI * 2,
            y: Math.PI / 2,
            scrollTrigger: {
                trigger: this.container,
                start: 'top top',
                end: 'bottom center',
                scrub: true,
                markers: false
            }
        });

        gsap.to(this.card.position, {
            y: -2,
            scrollTrigger: {
                trigger: this.container,
                start: 'top top',
                end: 'bottom center',
                scrub: true,
                markers: false
            }
        });
    }

    onWindowResize() {
        this.camera.aspect = this.container.clientWidth / this.container.clientHeight;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
    }

    animate() {
        requestAnimationFrame(() => this.animate());
        
        // Add subtle continuous rotation
        this.card.rotation.y += 0.005;
        
        this.renderer.render(this.scene, this.camera);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new Hero3D();
});