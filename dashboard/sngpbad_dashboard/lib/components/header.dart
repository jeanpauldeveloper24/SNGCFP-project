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
          // Titre de la plateforme ou indicateur de page
          Text(
            "SYSTÈME NATIONAL DE GESTION DES PROJETS",
            style: GoogleFonts.montserrat(
              fontSize: 14, 
              fontWeight: FontWeight.w600, 
              color: const Color(0xFF1B4F72)
            ),
          ),

          // Section Profil déplacée ici
          InkWell(
            onTap: () => onSectionSelected(AppRoutes.profile),
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
                      user.roleLabel,
                      style: const TextStyle(
                        fontSize: 11, 
                        color: Colors.grey
                      ),
                    ),
                  ],
                ),
                const SizedBox(width: 12),
                const CircleAvatar(
                  backgroundColor: Color(0xFF1B4F72),
                  child: Icon(Icons.person, color: Colors.white, size: 20),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}