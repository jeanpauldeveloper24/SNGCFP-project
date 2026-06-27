import 'dart:convert'; // Nécessaire pour base64Decode
import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:sngpbad_dashboard/models/user_model.dart';
import 'package:sngpbad_dashboard/routes.dart';

class Header extends StatelessWidget {
  final UserModel user;
  final Function(String) onSectionSelected;

  const Header({
    super.key, 
    required this.user, 
    required this.onSectionSelected
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      height: 70,
      padding: const EdgeInsets.symmetric(horizontal: 25),
      decoration: const BoxDecoration(
        color: Colors.white,
        border: Border(bottom: BorderSide(color: Colors.black12)),
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          // Titre du Dashboard
          Text(
            "SYSTÈME NATIONAL DE GESTION DES PROJETS",
            style: GoogleFonts.montserrat(
              fontSize: 14, 
              fontWeight: FontWeight.w800, 
              color: const Color(0xFF1B4F72)
            ),
          ),

          // Bloc Profil Utilisateur
          InkWell(
            onTap: () => onSectionSelected(AppRoutes.profile),
            borderRadius: BorderRadius.circular(8),
            child: Padding(
              padding: const EdgeInsets.all(8.0),
              child: Row(
                children: [
                  Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    crossAxisAlignment: CrossAxisAlignment.end,
                    children: [
                      Text(
                        user.name,
                        style: const TextStyle(
                          fontWeight: FontWeight.bold, 
                          fontSize: 14, 
                          color: Colors.black87
                        ),
                      ),
                      Text(
                        user.roleName.toUpperCase(),
                        style: const TextStyle(
                          fontSize: 10, 
                          fontWeight: FontWeight.w600, 
                          color: Color(0xFF27AE60)
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(width: 15),
                  
                  // Avatar avec gestion multi-sources (URL ou Base64)
                  Container(
                    padding: const EdgeInsets.all(2),
                    decoration: const BoxDecoration(
                      color: Color(0xFF1B4F72), 
                      shape: BoxShape.circle
                    ),
                    child: CircleAvatar(
                      radius: 20,
                      backgroundColor: Colors.white,
                      backgroundImage: user.photo.isNotEmpty 
                          ? (user.photo.startsWith('http') 
                              ? NetworkImage(user.photo) 
                              // --- DÉCODAGE BASE64 ICI ---
                              : MemoryImage(base64Decode(user.photo))) as ImageProvider
                          : null,
                      child: user.photo.isEmpty 
                          ? const Icon(Icons.person, color: Color(0xFF1B4F72)) 
                          : null,
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}