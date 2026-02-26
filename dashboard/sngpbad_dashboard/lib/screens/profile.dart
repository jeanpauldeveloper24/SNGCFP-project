import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:sngpbad_dashboard/models/user_model.dart';

class Profile extends StatefulWidget {
  final UserModel user; 

  const Profile({super.key, required this.user});

  @override
  State<Profile> createState() => _ProfileState();
}

class _ProfileState extends State<Profile> {
  final Color primaryBlue = const Color(0xFF1B4F72);
  // Remplace par l'IP de ton serveur Laravel
  final String storageBaseUrl = "http://127.0.0.1:8000/storage/";

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(30),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildProfileHeader(),
          const SizedBox(height: 30),
          Row(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Expanded(flex: 2, child: _buildInfoSection()),
              const SizedBox(width: 25),
              Expanded(flex: 1, child: _buildRoleCard()),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildProfileHeader() {
    final bool hasPhoto = widget.user.photo != null && widget.user.photo!.isNotEmpty;

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(35),
      decoration: BoxDecoration(
        gradient: LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [primaryBlue, const Color(0xFF2E86C1)],
        ),
        borderRadius: BorderRadius.circular(20),
        boxShadow: [BoxShadow(color: primaryBlue.withOpacity(0.3), blurRadius: 15, offset: const Offset(0, 8))],
      ),
      child: Row(
        children: [
          CircleAvatar(
            radius: 55,
            backgroundColor: Colors.white24,
            backgroundImage: hasPhoto ? NetworkImage(storageBaseUrl + widget.user.photo!) : null,
            child: !hasPhoto 
              ? Text(
                  widget.user.name.isNotEmpty ? widget.user.name[0].toUpperCase() : "?",
                  style: const TextStyle(fontSize: 45, color: Colors.white, fontWeight: FontWeight.bold),
                )
              : null,
          ),
          const SizedBox(width: 30),
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                widget.user.name, 
                style: GoogleFonts.montserrat(fontSize: 30, fontWeight: FontWeight.bold, color: Colors.white)
              ),
              const SizedBox(height: 5),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 4),
                decoration: BoxDecoration(color: Colors.white24, borderRadius: BorderRadius.circular(20)),
                child: Text(
                  widget.user.roleLabel, 
                  style: GoogleFonts.inter(fontSize: 14, color: Colors.white, fontWeight: FontWeight.w500)
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildInfoSection() {
    return Container(
      padding: const EdgeInsets.all(30),
      decoration: BoxDecoration(
        color: Colors.white, 
        borderRadius: BorderRadius.circular(20), 
        border: Border.all(color: Colors.black.withOpacity(0.05)),
        boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.02), blurRadius: 10)],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text("Informations du compte", style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold, color: primaryBlue)),
          const Divider(height: 50),
          _buildInfoRow(Icons.person_outline, "Nom complet", widget.user.name),
          _buildInfoRow(Icons.email_outlined, "Email institutionnel", widget.user.email),
          _buildInfoRow(Icons.phone_android_outlined, "Téléphone", widget.user.phone ?? "Non renseigné"),
          _buildInfoRow(Icons.settings_input_component_outlined, "Identifiant technique", widget.user.roleName),
          const SizedBox(height: 20),
          ElevatedButton.icon(
            onPressed: () {},
            icon: const Icon(Icons.edit_note, size: 20),
            label: const Text("Mettre à jour mes informations"),
            style: ElevatedButton.styleFrom(
              backgroundColor: primaryBlue, 
              foregroundColor: Colors.white,
              padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 15),
            ),
          )
        ],
      ),
    );
  }

  Widget _buildInfoRow(IconData icon, String label, String value) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 25),
      child: Row(
        children: [
          Container(
            padding: const EdgeInsets.all(10),
            decoration: BoxDecoration(color: backgroundGrey(), borderRadius: BorderRadius.circular(10)),
            child: Icon(icon, color: primaryBlue, size: 22),
          ),
          const SizedBox(width: 20),
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(label, style: GoogleFonts.inter(fontSize: 12, color: Colors.grey[500], fontWeight: FontWeight.w500)),
              Text(value, style: GoogleFonts.inter(fontSize: 16, fontWeight: FontWeight.w600, color: Colors.black87)),
            ],
          ),
        ],
      ),
    );
  }

  Color backgroundGrey() => const Color(0xFFF4F7F6);

  Widget _buildRoleCard() {
    return Container(
      padding: const EdgeInsets.all(30),
      decoration: BoxDecoration(
        color: Colors.white, 
        borderRadius: BorderRadius.circular(20), 
        border: Border.all(color: Colors.black.withOpacity(0.05))
      ),
      child: Column(
        children: [
          const Icon(Icons.verified_user, color: Color(0xFF27AE60), size: 50),
          const SizedBox(height: 20),
          Text(
            "Accès Certifié", 
            style: GoogleFonts.montserrat(fontWeight: FontWeight.bold, color: const Color(0xFF1B5E20), fontSize: 16)
          ),
          const SizedBox(height: 12),
          Text(
            "Votre compte est rattaché aux services officiels de la BAD Côte d'Ivoire. Vos accès sont gérés par la Direction Nationale.",
            textAlign: TextAlign.center,
            style: GoogleFonts.inter(fontSize: 13, color: Colors.grey[600], height: 1.5),
          ),
        ],
      ),
    );
  }
}