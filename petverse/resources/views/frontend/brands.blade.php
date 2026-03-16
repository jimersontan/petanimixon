@extends('frontend.layouts.app')

@section('title', 'Brands - Pet Animixon')

@section('content')
<!-- Hero Section -->
<div style="background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%); padding: 60px 20px; text-align: center; margin-bottom: 50px;">
    <h1 style="font-size: 40px; color: #333; margin: 0 0 15px 0; font-weight: 700;">Brands We Trust & Carry</h1>
    <p style="font-size: 16px; color: #666; margin: 0;">Partnering with industry leaders committed to quality and safety</p>
</div>

<div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <!-- Brand Category Tabs -->
    <div style="display: flex; justify-content: center; gap: 30px; margin-bottom: 50px; flex-wrap: wrap;">
        <a href="#all" style="padding-bottom: 10px; border-bottom: 3px solid var(--ud-orange, #FF8C42); color: var(--ud-orange, #FF8C42); text-decoration: none; font-weight: 600; cursor: pointer;">All Brands</a>
        <a href="#premium" style="padding-bottom: 10px; color: #666; text-decoration: none; font-weight: 600; cursor: pointer; transition: all 0.3s;">Premium</a>
        <a href="#budget" style="padding-bottom: 10px; color: #666; text-decoration: none; font-weight: 600; cursor: pointer; transition: all 0.3s;">Budget-Friendly</a>
        <a href="#eco" style="padding-bottom: 10px; color: #666; text-decoration: none; font-weight: 600; cursor: pointer; transition: all 0.3s;">Eco-Conscious</a>
        <a href="#specialty" style="padding-bottom: 10px; color: #666; text-decoration: none; font-weight: 600; cursor: pointer; transition: all 0.3s;">Specialty Brands</a>
    </div>

    <!-- Brands Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 25px; margin-bottom: 60px;">
        <!-- Brand Card 1 -->
        <div style="background: white; border-radius: 8px; padding: 30px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s;">
            <div style="height: 100px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <img src="https://via.placeholder.com/150x80?text=Royal+Canin" alt="Royal Canin" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
            <h3 style="font-size: 18px; font-weight: 700; color: #333; margin: 0 0 10px 0;">Royal Canin</h3>
            <p style="font-size: 14px; color: #666; margin: 0 0 15px 0;">Premium natural dog foods since 1985</p>
            <p style="font-size: 13px; color: #999; margin: 0 0 20px 0;">45 products</p>
            <a href="#" style="display: inline-block; padding: 10px 25px; border: 2px solid var(--ud-orange, #FF8C42); color: var(--ud-orange, #FF8C42); text-decoration: none; border-radius: 6px; font-weight: 600; transition: all 0.3s;">View Products</a>
        </div>

        <!-- Brand Card 2 -->
        <div style="background: white; border-radius: 8px; padding: 30px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s;">
            <div style="height: 100px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <img src="https://via.placeholder.com/150x80?text=Blue+Buffalo" alt="Blue Buffalo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
            <h3 style="font-size: 18px; font-weight: 700; color: #333; margin: 0 0 10px 0;">Blue Buffalo</h3>
            <p style="font-size: 14px; color: #666; margin: 0 0 15px 0;">Natural ingredients for healthier pets</p>
            <p style="font-size: 13px; color: #999; margin: 0 0 20px 0;">32 products</p>
            <a href="#" style="display: inline-block; padding: 10px 25px; border: 2px solid var(--ud-orange, #FF8C42); color: var(--ud-orange, #FF8C42); text-decoration: none; border-radius: 6px; font-weight: 600; transition: all 0.3s;">View Products</a>
        </div>

        <!-- Brand Card 3 -->
        <div style="background: white; border-radius: 8px; padding: 30px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s;">
            <div style="height: 100px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <img src="https://via.placeholder.com/150x80?text=Kong" alt="Kong" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
            <h3 style="font-size: 18px; font-weight: 700; color: #333; margin: 0 0 10px 0;">Kong</h3>
            <p style="font-size: 14px; color: #666; margin: 0 0 15px 0;">Durable toys for active pets</p>
            <p style="font-size: 13px; color: #999; margin: 0 0 20px 0;">78 products</p>
            <a href="#" style="display: inline-block; padding: 10px 25px; border: 2px solid var(--ud-orange, #FF8C42); color: var(--ud-orange, #FF8C42); text-decoration: none; border-radius: 6px; font-weight: 600; transition: all 0.3s;">View Products</a>
        </div>

        <!-- Brand Card 4 -->
        <div style="background: white; border-radius: 8px; padding: 30px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s;">
            <div style="height: 100px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <img src="https://via.placeholder.com/150x80?text=Fluval" alt="Fluval" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
            <h3 style="font-size: 18px; font-weight: 700; color: #333; margin: 0 0 10px 0;">Fluval</h3>
            <p style="font-size: 14px; color: #666; margin: 0 0 15px 0;">Premium aquarium equipment</p>
            <p style="font-size: 13px; color: #999; margin: 0 0 20px 0;">56 products</p>
            <a href="#" style="display: inline-block; padding: 10px 25px; border: 2px solid var(--ud-orange, #FF8C42); color: var(--ud-orange, #FF8C42); text-decoration: none; border-radius: 6px; font-weight: 600; transition: all 0.3s;">View Products</a>
        </div>

        <!-- Brand Card 5 -->
        <div style="background: white; border-radius: 8px; padding: 30px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s;">
            <div style="height: 100px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <img src="https://via.placeholder.com/150x80?text=Zoo+Med" alt="Zoo Med" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
            <h3 style="font-size: 18px; font-weight: 700; color: #333; margin: 0 0 10px 0;">Zoo Med</h3>
            <p style="font-size: 14px; color: #666; margin: 0 0 15px 0;">Complete reptile care solutions</p>
            <p style="font-size: 13px; color: #999; margin: 0 0 20px 0;">41 products</p>
            <a href="#" style="display: inline-block; padding: 10px 25px; border: 2px solid var(--ud-orange, #FF8C42); color: var(--ud-orange, #FF8C42); text-decoration: none; border-radius: 6px; font-weight: 600; transition: all 0.3s;">View Products</a>
        </div>

        <!-- Brand Card 6 -->
        <div style="background: white; border-radius: 8px; padding: 30px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s;">
            <div style="height: 100px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <img src="https://via.placeholder.com/150x80?text=Petco" alt="Petco" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
            <h3 style="font-size: 18px; font-weight: 700; color: #333; margin: 0 0 10px 0;">Petco</h3>
            <p style="font-size: 14px; color: #666; margin: 0 0 15px 0;">Trusted general pet supplies</p>
            <p style="font-size: 13px; color: #999; margin: 0 0 20px 0;">73 products</p>
            <a href="#" style="display: inline-block; padding: 10px 25px; border: 2px solid var(--ud-orange, #FF8C42); color: var(--ud-orange, #FF8C42); text-decoration: none; border-radius: 6px; font-weight: 600; transition: all 0.3s;">View Products</a>
        </div>

        <!-- Brand Card 7 -->
        <div style="background: white; border-radius: 8px; padding: 30px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s;">
            <div style="height: 100px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <img src="https://via.placeholder.com/150x80?text=Oxbow" alt="Oxbow" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
            <h3 style="font-size: 18px; font-weight: 700; color: #333; margin: 0 0 10px 0;">Oxbow</h3>
            <p style="font-size: 14px; color: #666; margin: 0 0 15px 0;">Nutrition for small pets</p>
            <p style="font-size: 13px; color: #999; margin: 0 0 20px 0;">24 products</p>
            <a href="#" style="display: inline-block; padding: 10px 25px; border: 2px solid var(--ud-orange, #FF8C42); color: var(--ud-orange, #FF8C42); text-decoration: none; border-radius: 6px; font-weight: 600; transition: all 0.3s;">View Products</a>
        </div>

        <!-- Brand Card 8 -->
        <div style="background: white; border-radius: 8px; padding: 30px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s;">
            <div style="height: 100px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <img src="https://via.placeholder.com/150x80?text=API" alt="API" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
            <h3 style="font-size: 18px; font-weight: 700; color: #333; margin: 0 0 10px 0;">API</h3>
            <p style="font-size: 14px; color: #666; margin: 0 0 15px 0;">Aquatic care products</p>
            <p style="font-size: 13px; color: #999; margin: 0 0 20px 0;">39 products</p>
            <a href="#" style="display: inline-block; padding: 10px 25px; border: 2px solid var(--ud-orange, #FF8C42); color: var(--ud-orange, #FF8C42); text-decoration: none; border-radius: 6px; font-weight: 600; transition: all 0.3s;">View Products</a>
        </div>
    </div>

    <!-- Why These Brands Section -->
    <div style="background-color: #fef5f0; padding: 60px 40px; border-radius: 12px; margin-bottom: 60px;">
        <h2 style="font-size: 32px; color: #333; text-align: center; margin: 0 0 50px 0; font-weight: 700;">Why These Brands?</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px;">
            <!-- Quality -->
            <div style="text-align: center;">
                <div style="font-size: 40px; margin-bottom: 15px;">✓</div>
                <h3 style="font-size: 18px; color: #333; margin: 0 0 10px 0; font-weight: 600;">Quality Standards</h3>
                <p style="font-size: 14px; color: #666; margin: 0;">Every brand is vetted for ingredients and safety</p>
            </div>

            <!-- Track Record -->
            <div style="text-align: center;">
                <div style="font-size: 40px; margin-bottom: 15px; color: var(--ud-orange, #FF8C42);">★</div>
                <h3 style="font-size: 18px; color: #333; margin: 0 0 10px 0; font-weight: 600;">Proven Track Record</h3>
                <p style="font-size: 14px; color: #666; margin: 0;">Brands with years of positive customer feedback</p>
            </div>

            <!-- Ethics -->
            <div style="text-align: center;">
                <div style="font-size: 40px; margin-bottom: 15px;">✈</div>
                <h3 style="font-size: 18px; color: #333; margin: 0 0 10px 0; font-weight: 600;">Ethical Practices</h3>
                <p style="font-size: 14px; color: #666; margin: 0;">Companies committed to animal welfare and sustainability</p>
            </div>
        </div>
    </div>

    <!-- Featured Brand Section -->
    <div style="background: white; border-radius: 12px; padding: 50px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center;">
            <!-- Left: Image -->
            <div>
                <div style="background: linear-gradient(135deg, #7fb3a3 0%, #6a9e8f 100%); border-radius: 12px; height: 400px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    <img src="https://via.placeholder.com/300x400?text=Royal+Canin+Featured" alt="Royal Canin" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>

            <!-- Right: Info -->
            <div>
                <div style="display: inline-block; background-color: var(--ud-orange, #FF8C42); color: white; padding: 6px 15px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 20px;">Featured Brand</div>
                
                <h2 style="font-size: 32px; color: #333; margin: 0 0 15px 0; font-weight: 700;">Royal Canin</h2>
                
                <p style="font-size: 14px; color: #666; line-height: 1.6; margin: 0 0 15px 0;">Royal Canin has been a pioneer in pet nutrition since 1968, creating breed-specific and health-focused formulas that veterinarians and pet owners trust worldwide.</p>

                <p style="font-size: 14px; color: #666; line-height: 1.6; margin: 0 0 20px 0;">Their scientific approach to nutrition combines precise nutrients with high-quality ingredients to support optimal health at every life stage.</p>

                <p style="font-size: 14px; color: #666; line-height: 1.6; margin: 0 0 25px 0;">From puppy to senior, Royal Canin offers tailored nutrition solutions that veterinarians trust and pet owners love.</p>

                <!-- Features List -->
                <ul style="list-style: none; padding: 0; margin: 0 0 30px 0;">
                    <li style="padding: 8px 0; font-size: 14px; color: #333;">✓ Breed-specific formulas</li>
                    <li style="padding: 8px 0; font-size: 14px; color: #333;">✓ Veterinary diet options</li>
                    <li style="padding: 8px 0; font-size: 14px; color: #333;">✓ Life stage nutrition</li>
                    <li style="padding: 8px 0; font-size: 14px; color: #333;">✓ Scientific research backing</li>
                </ul>

                <a href="#" style="display: inline-block; padding: 12px 35px; background-color: var(--ud-orange, #FF8C42); color: white; text-decoration: none; border-radius: 6px; font-weight: 600; transition: background-color 0.3s;">Shop Brand</a>
            </div>
        </div>
    </div>
</div>

<style>
    a:hover {
        opacity: 0.9;
    }

    [style*="border: 2px solid var(--ud-orange"]]:hover {
        background-color: var(--ud-orange, #FF8C42);
        color: white !important;
    }
</style>
@endsection
