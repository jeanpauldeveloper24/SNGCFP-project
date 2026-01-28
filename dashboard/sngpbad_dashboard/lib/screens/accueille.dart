import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class Accueille extends StatelessWidget {
  final String userName;
  const Accueille({super.key, required this.userName});

  @override
  Widget build(BuildContext context) {
    final Color primaryBlue = const Color(0xFF1B4F72);

    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          // Bandeau Logos
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
            children: [
              Image.asset('images/armoirie-ci.png', height: 120),
              Image.asset('images/logo-bad.png', height: 120),
            ],
          ),
          const SizedBox(height: 50),
          // Message de Bienvenue
          Text(
            "BIENVENUE SUR LE SNGP-BAD",
            style: GoogleFonts.montserrat(
              fontSize: 28, 
              fontWeight: FontWeight.bold, 
              color: primaryBlue,
              letterSpacing: 1.2
            ),
          ),
          const SizedBox(height: 10),
          Text(
            "Système Numérique de Gestion des Projets",
            style: GoogleFonts.inter(fontSize: 18, color: Colors.grey[600]),
          ),
          const SizedBox(height: 40),
          // Carte Utilisateur
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 30, vertical: 20),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(50),
              boxShadow: [BoxShadow(color: Colors.black12, blurRadius: 10)],
            ),
            child: Text(
              "Session de : $userName",
              style: GoogleFonts.inter(fontWeight: FontWeight.w600, color: primaryBlue),
            ),
          ),
        ],
      ),
    );
  }
}