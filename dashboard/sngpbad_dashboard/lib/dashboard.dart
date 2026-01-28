import 'package:flutter/material.dart';
import 'package:sngpbad_dashboard/components/app_drawer.dart';
import 'package:sngpbad_dashboard/components/content.dart';
import 'package:sngpbad_dashboard/components/header.dart';

import 'package:sngpbad_dashboard/models/user_model.dart';
import 'package:sngpbad_dashboard/routes.dart';

class Dashboard extends StatefulWidget {
  final UserModel user;
  const Dashboard({super.key, required this.user});

  @override
  State<Dashboard> createState() => _DashboardState();
}

class _DashboardState extends State<Dashboard> {
  // On initialise avec la route d'accueil par défaut
  String _selectedSection = AppRoutes.accueil;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4F7F9), // Fond légèrement gris pour faire ressortir les cartes blanches
      body: Column(
        children: [
          // ÉLÉMENT 1 : LE HEADER (Fixe en haut)
          Header(
            user: widget.user,
            onSectionSelected: (section) {
              setState(() => _selectedSection = section);
            },
          ),
          
          // ÉLÉMENT 2 : ZONE INFÉRIEURE (Drawer + Content)
          Expanded(
            child: Row(
              children: [
                // Tiroir de navigation gauche
                AppDrawer(
                  user: widget.user,
                  onSectionSelected: (section) {
                    setState(() => _selectedSection = section);
                  },
                ),
                
                // Zone de contenu dynamique
                Expanded(
                  child: Content(
                    user: widget.user,
                    sectionTitle: _selectedSection,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}