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
    // URL vers ton dossier storage Laravel
    const String storageBaseUrl = "http://127.0.0.1:8000/storage/";

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
          // Titre Institutionnel
          Text(
            "SYSTÈME NATIONAL DE GESTION DES PROJETS",
            style: GoogleFonts.montserrat(
              fontSize: 14, 
              fontWeight: FontWeight.w800, 
              color: const Color(0xFF1B4F72)
            ),
          ),

          // Bloc Profil (Nom, Rôle, Photo)
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
                        user.roleLabel.toUpperCase(),
                        style: const TextStyle(
                          fontSize: 10, 
                          fontWeight: FontWeight.w600,
                          color: Color(0xFF27AE60) // Vert pour le statut
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(width: 15),
                  
                  // Avatar avec bordure
                  Container(
                    padding: const EdgeInsets.all(2), // L'espace pour le liseré
                    decoration: const BoxDecoration(
                      color: Color(0xFF1B4F72),
                      shape: BoxShape.circle,
                    ),
                    child: CircleAvatar(
                      radius: 20,
                      backgroundColor: Colors.white,
                      backgroundImage: user.photo != null 
                          ? NetworkImage(storageBaseUrl + user.photo!) 
                          : null,
                      child: user.photo == null 
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